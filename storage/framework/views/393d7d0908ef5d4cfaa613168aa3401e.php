<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario Intersys</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestión de Inventario</h2>
        <div>
            <button class="btn btn-primary" id="btnNuevoProducto">Nuevo Producto</button>
            <a href="<?php echo e(route('reports.pdf')); ?>" class="btn btn-danger">Descargar Reporte del Mes (PDF)</a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover" id="productsTable">
                <thead>
                    <tr>
                        <th>SKU</th>
                        <th>Producto</th>
                        <th>Categoría</th>
                        <th>Stock</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr id="row-<?php echo e($product->id); ?>">
                        <td><?php echo e($product->sku); ?></td>
                        <td><?php echo e($product->name); ?></td>
                        <td><?php echo e($product->category->name); ?></td>
                        <td><?php echo e($product->stock); ?></td>
                        <td>$<?php echo e(number_format($product->price, 2)); ?></td>
                        <td>
                            <button class="btn btn-sm btn-warning btnEditar" data-id="<?php echo e($product->id); ?>">Editar</button>
                            <button class="btn btn-sm btn-danger btnEliminar" data-id="<?php echo e($product->id); ?>">Eliminar</button>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="productForm">
                <input type="hidden" id="product_id" name="product_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger d-none" id="formErrors"></div>
                    
                    <div class="mb-3">
                        <label>Categoría</label>
                        <select class="form-select" name="category_id" id="category_id" required>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Nombre</label>
                        <input type="text" class="form-control" name="name" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label>SKU</label>
                        <input type="text" class="form-control" name="sku" id="sku" required>
                    </div>
                    <div class="mb-3">
                        <label>Stock</label>
                        <input type="number" class="form-control" name="stock" id="stock" required>
                    </div>
                    <div class="mb-3">
                        <label>Precio</label>
                        <input type="number" step="0.01" class="form-control" name="price" id="price" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>

    
    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    const modal = new bootstrap.Modal(document.getElementById('productModal'));

    // Abrir Modal para Crear
    $('#btnNuevoProducto').click(function() {
        $('#productForm')[0].reset();
        $('#product_id').val('');
        $('#modalTitle').text('Agregar Producto');
        $('#formErrors').addClass('d-none');
        modal.show();
    });

    $(document).on('click', '.btnEditar', function() {
        const id = $(this).data('id');
        $('#formErrors').addClass('d-none');
        
        $.get(`/products/${id}`, function(product) {
            $('#product_id').val(product.id);
            $('#category_id').val(product.category_id);
            $('#name').val(product.name);
            $('#sku').val(product.sku);
            $('#stock').val(product.stock);
            $('#price').val(product.price);
            $('#modalTitle').text('Editar Producto');
            modal.show();
        });
    });

    $('#productForm').submit(function(e) {
        e.preventDefault();
        const id = $('#product_id').val();
        const url = id ? `/products/${id}` : '/products';
        const type = id ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            type: type,
            data: $(this).serialize(),
            success: function(response) {
                if(response.success) {
                    const p = response.product;
                    const rowHtml = `
                        <td>${p.sku}</td>
                        <td>${p.name}</td>
                        <td>${p.category.name}</td>
                        <td>${p.stock}</td>
                        <td>$${parseFloat(p.price).toFixed(2)}</td>
                        <td>
                            <button class="btn btn-sm btn-warning btnEditar" data-id="${p.id}">Editar</button>
                            <button class="btn btn-sm btn-danger btnEliminar" data-id="${p.id}">Eliminar</button>
                        </td>
                    `;
                    
                    if (id) {
                        $(`#row-${id}`).html(rowHtml);
                    } else {
                        $('#productsTable tbody').prepend(`<tr id="row-${p.id}">${rowHtml}</tr>`);
                    }
                    modal.hide();
                }
            },
            error: function(xhr) {
                if(xhr.status === 422) { // Errores de validación Laravel
                    let errors = xhr.responseJSON.errors;
                    let errorHtml = '<ul>';
                    $.each(errors, function(key, value) {
                        errorHtml += `<li>${value[0]}</li>`;
                    });
                    errorHtml += '</ul>';
                    $('#formErrors').html(errorHtml).removeClass('d-none');
                } else {
                    alert('Ocurrió un error inesperado en el servidor.');
                }
            }
        });
    });

    $(document).on('click', '.btnEliminar', function() {
        if(confirm('¿Estás seguro de eliminar este producto?')) {
            const id = $(this).data('id');
            $.ajax({
                url: `/products/${id}`,
                type: 'DELETE',
                success: function(response) {
                    if(response.success) {
                        $(`#row-${id}`).remove();
                    }
                }
            });
        }
    });
</script>
</body>
</html><?php /**PATH C:\laragon\www\CRUD_INTERSYS\resources\views/products/index.blade.php ENDPATH**/ ?>