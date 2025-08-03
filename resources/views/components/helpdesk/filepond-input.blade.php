<div wire:ignore 
    x-data="{ uploading: false }"
    x-init="
        FilePond.registerPlugin(
            FilePondPluginImagePreview,
            FilePondPluginFileValidateType,
            FilePondPluginFileValidateSize
        );
        FilePond.setOptions({
            server: {
                process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    uploading = true;
                    $dispatch('uploading-changed', { isUploading: uploading });

                    const uploadTask = @this.upload(
                        '{{ $attributes['wire:model'] }}',
                        file,
                        (tempFilename) => {
                            load(tempFilename);
                            uploading = false;
                            $dispatch('uploading-changed', { isUploading: uploading });
                        },
                        (errMsg) => {
                            error(errMsg);
                            uploading = false;
                            $dispatch('uploading-changed', { isUploading: uploading });
                        },
                        (event) => {
                            progress(event.lengthComputable, event.loaded, event.total);
                        }
                    );

                    return {
                        abort: () => {
                            uploadTask.abort();
                            uploading = false;
                            $dispatch('uploading-changed', { isUploading: uploading });
                            abort();
                        }
                    };
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
            labelIdle: `
                <div class='filepond--drop-label-content'>
                    <span class='filepond--label-icon'>
                        <svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' 
                        fill='none' stroke='currentColor' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'>
                            <path d='M12 13v8'/>
                            <path d='M4 14.899A7 7 0 1 1 15.71 8h1.79a4.5 4.5 0 0 1 2.5 8.242'/>
                            <path d='m8 17 4-4 4 4'/>
                    </svg>
                    </span>
                    <div class='filepond--label-main-content'>
                        <p>Arrastra y suelta un archivo o <span class='filepond--label-action'>haz click</span> para subir</p>
                        <p class='filepond--label-allowed-files'>Imágen o PDF (Máx. 10MB)</p>
                    </div>
                </div>
            `,
            labelFileProcessingComplete: 'Carga completa',
            labelFileProcessing: 'Cargando',
            labelFileProcessingError: 'Error durante la carga',
            labelFileTypeNotAllowed: 'El tipo de archivo no es válido',
            fileValidateTypeLabelExpectedTypes: 'Se esperó {allButLastType} o {lastType}',
            fileValidateTypeLabelExpectedTypesMap: { 'image/*': 'imagen' , 'application/pdf': 'PDF' },
            labelMaxFileSizeExceeded: 'Archivo demasiado grande',
            labelMaxFileSize: 'El tamaño máximo es {filesize}',
            labelTapToCancel: 'Toca para cancelar',
            labelTapToRetry: 'Toca para reintentar',
            labelTapToUndo: 'Toque para deshacer',
            credits: '',
        });"
        class="custom">
    <input type="file" x-ref="input" class="filepond" wire:model="{{ $attributes['wire:model'] }}" >
</div>
