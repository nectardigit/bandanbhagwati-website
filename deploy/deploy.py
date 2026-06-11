#!/usr/bin/env python3
"""Deploy helper for bandanbhagwati.com — reads credentials from .vscode/sftp.json.
Usage: python deploy/deploy.py <command> [args]
Commands: diag | run "<remote cmd>" | put <local> <remote> | putdir <localdir> <remotedir>
"""
import json
import os
import sys
import stat
import posixpath

import paramiko

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))


def cfg():
    with open(os.path.join(ROOT, ".vscode", "sftp.json"), "r", encoding="utf-8") as f:
        return json.load(f)


def connect(c):
    cli = paramiko.SSHClient()
    cli.set_missing_host_key_policy(paramiko.AutoAddPolicy())
    cli.connect(c["host"], port=c.get("port", 22), username=c["username"],
                password=c["password"], timeout=30, look_for_keys=False, allow_agent=False)
    return cli


def run(cli, cmd):
    stdin, stdout, stderr = cli.exec_command(cmd, timeout=600)
    out = stdout.read().decode("utf-8", "replace")
    err = stderr.read().decode("utf-8", "replace")
    return out, err


def main():
    c = cfg()
    cmd = sys.argv[1] if len(sys.argv) > 1 else "diag"
    cli = connect(c)
    remote = c["remotePath"].rstrip("/")

    if cmd == "diag":
        checks = [
            ("whoami", "whoami"),
            ("home", "echo $HOME"),
            ("php version", "php -v 2>&1 | head -1"),
            ("php-cli alts", "ls /usr/local/bin/ea-php* /opt/cpanel/ea-php*/root/usr/bin/php 2>/dev/null | head"),
            ("composer", "which composer || ls ~/composer.phar 2>/dev/null || echo none"),
            ("mysql client", "which mysql || echo none"),
            ("domain dir", f"ls -la {remote} | head -40"),
            ("has artisan?", f"test -f {remote}/artisan && echo yes || echo no"),
            ("has vendor?", f"test -d {remote}/vendor && echo yes || echo no"),
            ("has .env?", f"test -f {remote}/.env && echo yes || echo no"),
            ("has public/?", f"test -d {remote}/public && echo yes || echo no"),
            ("public_html link", "ls -la ~/public_html 2>/dev/null | head -3"),
            ("docroot of domain", "cat ~/.cpanel/datastore 2>/dev/null | head; ls -la ~/bandanbhagwati.com 2>/dev/null | head -3"),
            ("disk", "df -h ~ 2>/dev/null | tail -1"),
        ]
        for label, cc in checks:
            out, err = run(cli, cc)
            print(f"--- {label} ---")
            print((out or err).rstrip() or "(empty)")
        cli.close()
        return

    if cmd == "run":
        out, err = run(cli, sys.argv[2])
        sys.stdout.write(out)
        if err:
            sys.stderr.write("[stderr] " + err)
        cli.close()
        return

    if cmd == "put":
        sftp = cli.open_sftp()
        sftp.put(sys.argv[2], sys.argv[3])
        print(f"uploaded {sys.argv[2]} -> {sys.argv[3]}")
        sftp.close(); cli.close()
        return

    print("unknown command", cmd)
    cli.close()


if __name__ == "__main__":
    main()
