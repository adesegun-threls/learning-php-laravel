<div>
    <div
        class="bg-white dark:bg-gray-900"
        wire:ignore
        data-page-builder-root
        data-initial-doc='@json($tiptapDoc)'
        data-layouts='@json($layouts)'
        data-blueprint-versions='@json($blueprintVersions)'
        data-relationship-types='@json($relationshipTypes)'
        data-compositions='@json($compositions)'
    ></div>

    <script>
        window.filamentPageBuilder = {
            api: {
                prefix: '@php echo config("filament-page-builder.api.prefix", "api") @endphp',
            }
        };

        document.addEventListener('livewire:initialized', () => {
            const root = document.querySelector('[data-page-builder-root]');
            if (!root) return;

            const form = root.closest('form');
            if (form) {
                form.addEventListener('submit', () => {
                    root.dispatchEvent(
                        new CustomEvent('page-builder:request-save', {
                            bubbles: false,
                        }),
                    );
                });
            }

            root.addEventListener('page-builder:save', (event) => {
                const detail = event.detail || {};
                const tiptapDoc = detail.tiptapDoc || {};
                const compiled = detail.compiled || [];
                @this.call('saveContent', tiptapDoc, compiled);
            });
        });
    </script>
</div>
