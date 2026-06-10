@php
    $statePath = $getStatePath();
    $isMultiple = $multiple ?? false;
@endphp

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <div
        wire:ignore
        x-data="{
            state: $wire.$entangle('{{ $statePath }}'),
            multiple: {{ $isMultiple ? 'true' : 'false' }},
            get items() {
                if (! this.multiple) return [];
                if (Array.isArray(this.state)) return this.state;
                return this.state ? [this.state] : [];
            },
            resolve(v) {
                if (! v) return '';
                if (/^(https?:)?\/\//.test(v) || v.charAt(0) === '/' || v.indexOf('data:') === 0) return v;
                return '{{ url('/storage') }}/' + String(v).replace(/^\/+/, '');
            },
            open() {
                const self = this;
                window.SetUrl = function (items) {
                    const list = (Array.isArray(items) ? items : [items]).map(function (i) {
                        return (i && i.url) ? i.url : i;
                    }).filter(Boolean);
                    if (! list.length) return;
                    if (self.multiple) {
                        const cur = Array.isArray(self.state) ? self.state.slice() : (self.state ? [self.state] : []);
                        self.state = cur.concat(list);
                    } else {
                        self.state = list[0];
                    }
                };
                window.open('{{ url('/filemanager') }}?type=Images', 'FileManager', 'width=900,height=600,scrollbars=yes,resizable=yes');
            },
            clear() { this.state = this.multiple ? [] : null; },
            removeAt(i) {
                const a = Array.isArray(this.state) ? this.state.slice() : [];
                a.splice(i, 1);
                this.state = a;
            },
        }"
        class="space-y-3"
    >
        {{-- Single preview --}}
        <template x-if="! multiple && state">
            <div>
                <img :src="resolve(state)" alt="" style="max-height:140px;border-radius:10px;border:1px solid rgb(228 228 231)">
            </div>
        </template>

        {{-- Multiple previews --}}
        <template x-if="multiple">
            <div style="display:flex;flex-wrap:wrap;gap:10px">
                <template x-for="(img, idx) in items" :key="idx">
                    <div style="position:relative">
                        <img :src="resolve(img)" alt="" style="height:90px;width:90px;object-fit:cover;border-radius:10px;border:1px solid rgb(228 228 231)">
                        <button type="button" @click="removeAt(idx)" title="Remove"
                            style="position:absolute;top:-7px;right:-7px;background:#ef4444;color:#fff;border:none;border-radius:9999px;width:22px;height:22px;line-height:20px;cursor:pointer;font-size:13px">&times;</button>
                    </div>
                </template>
            </div>
        </template>

        {{-- Controls --}}
        <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap">
            <button type="button" @click="open()"
                class="fi-btn fi-btn-size-md"
                style="display:inline-flex;align-items:center;gap:6px;padding:7px 14px;border-radius:8px;background:#f5a000;color:#fff;font-weight:600;font-size:13px;cursor:pointer;border:none">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 7a2 2 0 0 1 2-2h4l2 2h8a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                <span x-text="multiple ? 'Add from File Manager' : 'Choose from File Manager'"></span>
            </button>
            <button type="button" x-show="(! multiple && state) || (multiple && items.length)" @click="clear()"
                style="padding:7px 12px;border-radius:8px;background:#f3f4f6;color:#374151;font-size:13px;cursor:pointer;border:1px solid #e5e7eb">
                Clear
            </button>
        </div>
    </div>
</x-dynamic-component>
