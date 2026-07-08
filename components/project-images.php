<style>.image-preview-container{display:flex;gap:10px;flex-wrap:wrap;min-height:70px}.image-thumb{width:70px;height:70px;border-radius:8px;object-fit:cover;cursor:pointer;border:1px solid #ddd;transition:.25s}.image-thumb:hover{transform:scale(1.05);box-shadow:0 4px 10px rgb(0 0 0 / .2)}.image-preview-box{position:relative;display:inline-block;margin:5px}.image-thumb{width:90px;height:90px;border-radius:8px;object-fit:cover;border:1px solid #ddd}.image-delete-btn{position:absolute;top:-8px;right:-8px;width:22px;height:22px;border:none;border-radius:50%;background:#dc3545;color:#fff;cursor:pointer;font-weight:700}.image-preview-modal{display:none;position:fixed;z-index:99999;left:0;top:0;width:100%;height:100%;background:rgb(0 0 0 / .85);justify-content:center;align-items:center}.image-preview-modal img{max-width:90%;max-height:90%;border-radius:10px}.image-preview-close{position:absolute;right:35px;top:20px;font-size:45px;color:#fff;cursor:pointer;font-weight:700}</style>
<div class="main-card" style="margin-top:30px;" id="projectImagesSection">
    <div class="page-header mb-0">
        <h2 class="page-title">Project Images</h2>
    </div>
    <p class="text-muted mb-4">Upload project related images. Only 3D Render Images can be AI enhanced.</p>
    <div class="table-responsive">
        <table class="table table-bordered align-middle" id="projectImagesTable">
            <thead>
                <tr>
                    <th style="width:20%;">Image Type</th>
                    <th style="width:25%;">Upload Images</th>
                    <th style="width:45%;">Preview</th>
                    <th style="width:10%;">Actions</th>
                </tr>
            </thead>
            <tbody id="projectImagesTableBody">
                <tr>
                    <td><strong>3D Render Images</strong></td>
                    <td><input type="file" id="renderImages" class="form-control" multiple accept="image/*"></td>
                    <td><div id="renderPreview" class="image-preview-container"></div></td>
                    <td><button type="button" class="btn btn-warning btn-sm" id="enhanceRenderBtn" disabled>Enhance</button></td>
                </tr>
                <tr>
                    <td><strong>Floor Plan Images</strong></td>
                    <td><input type="file" id="floorImages" class="form-control" multiple accept="image/*"></td>
                    <td><div id="floorPreview" class="image-preview-container"></div></td>
                    <td>-</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="card mt-3" style="background:#f8fafc;">
        <div class="row">
            <div class="col-md-3">
                <strong>3D Renders :</strong>
                <span id="renderImageCount">0</span>
            </div>
            <div class="col-md-3">
                <strong>Floor Plans :</strong>
                <span id="floorImageCount">0</span>
            </div>
            <div class="col-md-3">
                <strong>Elevations :</strong>
                <span id="elevationImageTotal">0</span>
            </div>
            <div class="col-md-3 text-end">
                <strong>Total Images :</strong>
                <span id="grandImageCount">0</span>
            </div>
        </div>
    </div>
</div>
<div id="imagePreviewModal" class="image-preview-modal">
    <span class="image-preview-close">&times;</span>
    <img id="imagePreviewModalImg">
</div>