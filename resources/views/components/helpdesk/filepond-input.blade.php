<div wire:ignore 
    x-data 
    x-init="
        FilePond.registerPlugin(FilePondPluginImagePreview);
        FilePond.registerPlugin(FilePondPluginFileValidateType);
        FilePond.registerPlugin(FilePondPluginFileValidateSize);
        FilePond.setOptions({
            server: {
                process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    @this.upload('{{ $attributes['wire:model'] }}', file, load, error, progress)
                },
                revert: (filename, load, error) => {
                    @this.removeUpload('{{ $attributes['wire:model'] }}', filename, load)
                },
            },
        });
        FilePond.create($refs.input, {
            acceptedFileTypes: ['image/*','application/pdf'],
            maxFileSize: '10240KB',
            maxFiles: 1,
            dropOnPage: true,
            dropOnElement: false,
            labelIdle: `<span class='filepond--drop-icon'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' 
                                fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'>
                                <path d='M12 3v12'/>
                                <path d='m17 8-5-5-5 5'/><path d='M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4'/>
                            </svg>
                        </span>
                        <p>Arrastra y suelta un archivo o <span class='filepond--label-action'>haz click</span> para subir</p>`,
            labelFileProcessingComplete: 'Carga completa',
            labelFileProcessing: 'Cargando',
            labelFileProcessingError: 'Error durante la carga',
            labelFileTypeNotAllowed: 'El archivo es de un tipo no válido',
            fileValidateTypeLabelExpectedTypes: 'Se esperó {allButLastType} o {lastType}',
            fileValidateTypeLabelExpectedTypesMap: { 'image/*': 'imagen' , 'application/pdf': 'PDF' },
            labelMaxFileSizeExceeded: 'El archivo es demasiado grande',
            labelMaxFileSize: 'El tamaño máximo del archivo es de {filesize}',
            labelTapToCancel: 'Toca para cancelar',
            labelTapToRetry: 'Toca para reintentar',
            labelTapToUndo: 'Toque para deshacer',
            credits: '',
        });"
        class="custom">
    <input type="file" x-ref="input" class="filepond" wire:model="{{ $attributes['wire:model'] }}" >
</div>
