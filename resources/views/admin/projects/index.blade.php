@extends('layouts.admin')

@section('title', 'Gestión de Proyectos — Sytro Digital')
@section('header_title', 'Proyectos Realizados')

@section('content')
<div style="display: flex; flex-direction: column; gap: 28px;">

    <!-- Section Header Texts -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">
                <svg style="width: 20px; height: 20px; color: #0db5c0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                <span>Encabezado de la Sección de Proyectos</span>
            </h3>
        </div>
        <form action="{{ route('admin.projects.header') }}" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label" for="projects_heading">Título de la Sección</label>
                <input type="text" id="projects_heading" name="projects_heading" class="admin-input" value="{{ old('projects_heading', $heading) }}" required>
            </div>
            <div class="form-group">
                <label class="form-label" for="projects_subheading">Subtítulo / Bajada</label>
                <textarea id="projects_subheading" name="projects_subheading" class="admin-textarea" rows="2">{{ old('projects_subheading', $subheading) }}</textarea>
            </div>
            <button type="submit" class="admin-btn-secondary admin-btn-sm">
                Guardar Títulos
            </button>
        </form>
    </div>

    <!-- Add New Project -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">
                <svg style="width: 20px; height: 20px; color: #34d399;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Agregar Nuevo Proyecto</span>
            </h3>
        </div>
        <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 16px;">
                <div class="form-group">
                    <label class="form-label" for="new_tag">Etiqueta / Sector *</label>
                    <input type="text" id="new_tag" name="tag" class="admin-input" placeholder="Ej: Sector salud, Financiero..." required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="new_title">Nombre del Proyecto *</label>
                    <input type="text" id="new_title" name="title" class="admin-input" placeholder="Ej: Sistema de citas médicas" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="new_order">Orden de aparición</label>
                    <input type="number" id="new_order" name="order" class="admin-input" value="{{ $projects->count() + 1 }}" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="new_desc">Descripción del Proyecto *</label>
                <textarea id="new_desc" name="description" class="admin-textarea" rows="2" placeholder="Resumen de la plataforma y el problema que resuelve..." required></textarea>
            </div>

            <!-- Image Upload & Preview -->
            <div class="form-group" data-image-gallery style="background: rgba(0, 0, 0, 0.2); padding: 16px; border-radius: 8px; border: 1px dashed var(--admin-border);">
                    <label class="form-label" for="new_images" style="display: flex; align-items: center; gap: 8px;">
                    <svg style="width: 18px; height: 18px; color: #0db5c0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    <span>Fotos del Proyecto</span>
                </label>
                <input type="file" id="new_images" name="images[]" class="admin-input" accept="image/jpeg,image/png,image/webp" multiple data-photo-input style="padding: 8px;">
                <div data-photo-preview-label hidden style="margin-top: 12px; color: #6fe4d6; font-size: 0.82rem; font-weight: 600;">Vista previa — estas fotos aún no se han publicado.</div>
                <div data-photo-preview style="display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: 12px; margin-top: 8px;"></div>
                <div class="form-hint" data-photo-status aria-live="polite">Aún no has seleccionado fotos.</div>
                <div class="form-hint">Puedes elegir varias a la vez o abrir el selector varias veces antes de guardar; se irán acumulando. JPG, PNG o WebP, máx. 5MB cada una.</div>
                <button type="button" class="admin-btn-secondary admin-btn-sm" data-photo-clear disabled style="margin-top: 8px;">Limpiar selección</button>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 16px;">
                <div class="form-group">
                    <label class="form-label" for="new_result">Resultado / Logro Destacado</label>
                    <input type="text" id="new_result" name="result" class="admin-input" placeholder="Ej: Reducción del 40% en tiempos de espera">
                </div>
                <div class="form-group">
                    <label class="form-label" for="new_url">Enlace / Demo (Opcional)</label>
                    <input type="url" id="new_url" name="url" class="admin-input" placeholder="https://...">
                </div>
            </div>

            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px;">
                <label style="display: flex; align-items: center; gap: 8px; font-size: 0.88rem; color: #d1dfed; cursor: pointer;">
                    <input type="checkbox" name="is_active" value="1" checked style="accent-color: #0db5c0;">
                    <span>Mostrar en vitrina de proyectos (Activo)</span>
                </label>

                <button type="submit" class="admin-btn-primary">
                    <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    <span>Crear Proyecto</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Projects List -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">
                <svg style="width: 20px; height: 20px; color: #f4c77b;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                <span>Proyectos Registrados ({{ $projects->count() }})</span>
            </h3>
        </div>

        <div style="display: flex; flex-direction: column; gap: 20px;">
            @forelse($projects as $project)
                <div style="background: rgba(8, 20, 34, 0.85); border: 1px solid var(--admin-border); border-radius: 12px; padding: 22px;">
                    <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div style="display: grid; grid-template-columns: 200px 1fr 100px; gap: 14px; margin-bottom: 12px;">
                            <div>
                                <label class="form-label">Sector / Tag</label>
                                <input type="text" name="tag" class="admin-input" value="{{ $project->tag }}" required>
                            </div>
                            <div>
                                <label class="form-label">Título del Proyecto</label>
                                <input type="text" name="title" class="admin-input" value="{{ $project->title }}" required>
                            </div>
                            <div>
                                <label class="form-label">Orden</label>
                                <input type="number" name="order" class="admin-input" value="{{ $project->order }}" required>
                            </div>
                        </div>

                        <div class="form-group" style="margin-bottom: 14px;">
                            <label class="form-label">Descripción</label>
                            <textarea name="description" class="admin-textarea" rows="2" required>{{ $project->description }}</textarea>
                        </div>

                        <!-- Image Section in Edit -->
                        <div class="form-group" data-image-gallery style="background: rgba(0, 0, 0, 0.22); padding: 16px; border-radius: 8px; border: 1px solid var(--admin-border); margin-bottom: 16px;">
                            <label class="form-label" style="display: flex; align-items: center; gap: 8px;">
                                <svg style="width: 17px; height: 17px; color: #0db5c0;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <span>Fotos del Proyecto</span>
                            </label>

                            <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: 12px; margin-bottom: 14px;">
                                @if($project->image)
                                    <div style="min-width: 0;">
                                        <div style="position: relative; border-radius: 8px; overflow: hidden; border: 1px solid var(--admin-border); height: 90px; background: #061524;">
                                            <img src="{{ $project->image_url }}" alt="{{ $project->image_description ?: $project->title }}" data-image-caption="{{ $project->image_description ?: $project->title }}" data-fullscreen-image role="button" tabindex="0" aria-label="Ver imagen completa: {{ $project->title }}" style="width: 100%; height: 100%; object-fit: cover; cursor: zoom-in;">
                                            <a href="{{ $project->image_url }}" target="_blank" style="position: absolute; bottom: 4px; right: 4px; background: rgba(0,0,0,0.7); color: #fff; padding: 2px 6px; font-size: 0.68rem; border-radius: 4px; text-decoration: none;">Ver ↗</a>
                                        </div>
                                        <label class="form-label" style="margin-top: 8px;">Descripción de la imagen</label>
                                        <textarea name="image_description" class="admin-textarea" rows="2" maxlength="1000" placeholder="Describe lo que aparece en esta imagen">{{ $project->image_description }}</textarea>
                                        <label style="display: inline-flex; align-items: center; gap: 6px; margin-top: 6px; font-size: 0.8rem; color: #f87171; cursor: pointer;">
                                            <input type="checkbox" name="remove_image" value="1" style="accent-color: #ef4444;">
                                            <span>Eliminar</span>
                                        </label>
                                    </div>
                                @endif
                                @foreach($project->images as $projectImage)
                                    <div style="min-width: 0;">
                                        <div style="position: relative; border-radius: 8px; overflow: hidden; border: 1px solid var(--admin-border); height: 90px; background: #061524;">
                                            <img src="{{ $projectImage->url }}" alt="{{ $projectImage->description ?: $project->title }}" data-image-caption="{{ $projectImage->description ?: $project->title }}" data-fullscreen-image role="button" tabindex="0" aria-label="Ver imagen completa: {{ $project->title }}" style="width: 100%; height: 100%; object-fit: cover; cursor: zoom-in;">
                                            <a href="{{ $projectImage->url }}" target="_blank" style="position: absolute; bottom: 4px; right: 4px; background: rgba(0,0,0,0.7); color: #fff; padding: 2px 6px; font-size: 0.68rem; border-radius: 4px; text-decoration: none;">Ver ↗</a>
                                        </div>
                                        <label class="form-label" style="margin-top: 8px;">Descripción de la imagen</label>
                                        <textarea name="image_descriptions[{{ $projectImage->id }}]" class="admin-textarea" rows="2" maxlength="1000" placeholder="Describe lo que aparece en esta imagen">{{ $projectImage->description }}</textarea>
                                        <label style="display: inline-flex; align-items: center; gap: 6px; margin-top: 6px; font-size: 0.8rem; color: #f87171; cursor: pointer;">
                                            <input type="checkbox" name="remove_images[]" value="{{ $projectImage->id }}" style="accent-color: #ef4444;">
                                            <span>Eliminar</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <input type="file" name="images[]" class="admin-input" accept="image/jpeg,image/png,image/webp" multiple data-photo-input style="padding: 8px;">
                            <div data-photo-preview-label hidden style="margin-top: 12px; color: #6fe4d6; font-size: 0.82rem; font-weight: 600;">Vista previa — estas fotos aún no se han publicado.</div>
                            <div data-photo-preview style="display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: 12px; margin-top: 8px;"></div>
                            <div class="form-hint" data-photo-status aria-live="polite" style="margin-top: 6px;">Aún no has seleccionado fotos.</div>
                            <div class="form-hint">Puedes elegir varias a la vez o abrir el selector varias veces antes de actualizar; se irán acumulando. Máx. 5MB cada una. Marca “Eliminar” para quitar fotos existentes.</div>
                            <button type="button" class="admin-btn-secondary admin-btn-sm" data-photo-clear disabled style="margin-top: 8px;">Limpiar selección</button>
                        </div>

                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 14px; margin-bottom: 14px;">
                            <div>
                                <label class="form-label">Resultado Destacado</label>
                                <input type="text" name="result" class="admin-input" value="{{ $project->result }}">
                            </div>
                            <div>
                                <label class="form-label">Enlace URL (Opcional)</label>
                                <input type="url" name="url" class="admin-input" value="{{ $project->url }}" placeholder="https://...">
                            </div>
                        </div>

                        <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px;">
                            <label style="display: flex; align-items: center; gap: 8px; font-size: 0.86rem; color: #b5c7d8; cursor: pointer;">
                                <input type="checkbox" name="is_active" value="1" {{ $project->is_active ? 'checked' : '' }} style="accent-color: #0db5c0;">
                                <span>Activo en vitrina</span>
                            </label>

                            <div style="display: flex; align-items: center; gap: 10px;">
                                <button type="submit" class="admin-btn-secondary admin-btn-sm" style="color: #6fe4d6;">
                                    <svg style="width: 15px; height: 15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    <span>Actualizar Proyecto</span>
                                </button>
                    </form>
                                <form action="{{ route('admin.projects.destroy', $project) }}" method="POST" onsubmit="return confirm('¿Eliminar este proyecto?');" style="margin: 0;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="admin-btn-danger">
                                        <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        <span>Eliminar</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                </div>
            @empty
                <div style="text-align: center; padding: 30px; color: #8fa2b6;">
                    No hay proyectos registrados.
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

<dialog class="image-lightbox" data-image-lightbox aria-label="Visor de imágenes">
    <form method="dialog" class="image-lightbox-close-form">
        <button class="image-lightbox-close" type="submit" data-lightbox-close aria-label="Cerrar imagen" autofocus><span>Cerrar</span><span aria-hidden="true">&times;</span></button>
    </form>
    <button class="image-lightbox-nav image-lightbox-prev" type="button" data-lightbox-prev aria-label="Imagen anterior">&#10094;</button>
    <figure class="image-lightbox-figure">
        <img data-lightbox-image alt="">
        <figcaption data-lightbox-caption></figcaption>
    </figure>
    <button class="image-lightbox-nav image-lightbox-next" type="button" data-lightbox-next aria-label="Imagen siguiente">&#10095;</button>
    <span class="image-lightbox-counter" data-lightbox-counter aria-live="polite"></span>
    <span class="image-lightbox-hint">Pulsa Esc o haz clic en la imagen para salir</span>
</dialog>

@push('scripts')
<script>
    document.querySelectorAll('[data-photo-input]').forEach((input) => {
        const status = input.parentElement.querySelector('[data-photo-status]');
        const clearButton = input.parentElement.querySelector('[data-photo-clear]');
        const previewLabel = input.parentElement.querySelector('[data-photo-preview-label]');
        const preview = input.parentElement.querySelector('[data-photo-preview]');
        let selectedFiles = [];
        let previewUrls = [];

        const updateSelection = () => {
            previewUrls.forEach((url) => URL.revokeObjectURL(url));
            previewUrls = [];
            preview.replaceChildren();

            const transfer = new DataTransfer();
            selectedFiles.forEach(({ file }) => transfer.items.add(file));
            input.files = transfer.files;

            selectedFiles.forEach((selectedImage) => {
                const { file } = selectedImage;
                const imageUrl = URL.createObjectURL(file);
                previewUrls.push(imageUrl);

                const tile = document.createElement('div');
                tile.style.cssText = 'min-width: 0;';

                const imageWrap = document.createElement('div');
                imageWrap.style.cssText = 'height: 90px; overflow: hidden; border: 1px solid var(--admin-border); border-radius: 8px; background: #061524;';

                const image = document.createElement('img');
                image.src = imageUrl;
                image.alt = selectedImage.description || file.name;
                image.title = file.name;
                image.dataset.imageCaption = selectedImage.description || file.name;
                image.dataset.fullscreenImage = '';
                image.tabIndex = 0;
                image.setAttribute('role', 'button');
                image.setAttribute('aria-label', `Ver imagen completa: ${file.name}`);
                image.style.cssText = 'width: 100%; height: 100%; object-fit: cover;';

                const filename = document.createElement('div');
                filename.textContent = file.name;
                filename.title = file.name;
                filename.style.cssText = 'overflow: hidden; text-overflow: ellipsis; white-space: nowrap; margin-top: 5px; color: #b5c7d8; font-size: 0.75rem;';

                const description = document.createElement('textarea');
                description.name = 'new_image_descriptions[]';
                description.className = 'admin-textarea';
                description.rows = 2;
                description.maxLength = 1000;
                description.placeholder = 'Descripción de esta imagen';
                description.setAttribute('aria-label', `Descripción de ${file.name}`);
                description.dataset.imageDescription = '';
                description.value = selectedImage.description;
                description.style.cssText = 'margin-top: 8px; min-height: 58px;';
                description.addEventListener('input', () => {
                    selectedImage.description = description.value;
                    image.alt = description.value || file.name;
                    image.dataset.imageCaption = description.value || file.name;
                });

                imageWrap.append(image);
                tile.append(imageWrap, filename, description);
                preview.append(tile);
            });

            status.textContent = selectedFiles.length
                ? `${selectedFiles.length} foto(s) listas para subir. Puedes verlas en la vista previa.`
                : 'Aún no has seleccionado fotos.';
            previewLabel.hidden = selectedFiles.length === 0;
            clearButton.disabled = selectedFiles.length === 0;
        };

        input.addEventListener('change', () => {
            preview.querySelectorAll('[data-image-description]').forEach((description, index) => {
                if (selectedFiles[index]) {
                    selectedFiles[index].description = description.value;
                }
            });

            Array.from(input.files).forEach((file) => {
                const alreadySelected = selectedFiles.some((selected) =>
                    selected.file.name === file.name && selected.file.size === file.size && selected.file.lastModified === file.lastModified
                );

                if (!alreadySelected) {
                    selectedFiles.push({ file, description: '' });
                }
            });

            updateSelection();
        });

        clearButton.addEventListener('click', () => {
            selectedFiles = [];
            input.value = '';
            updateSelection();
        });
    });
</script>
@endpush
