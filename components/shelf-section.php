<div class="shelf-wrapper mt-4">
    <div class="generated-title">Shelves</div>
    <label>Does it have shelves?</label>
    <div class="d-flex gap-3 mb-3">
        <label><input type="radio" name="shelfOption" value="yes" onchange="toggleShelfSection(this)">Yes</label>
        <label><input type="radio" name="shelfOption" value="no" checked onchange="toggleShelfSection(this)">No</label>
    </div>
    <div class="shelf-section" style="display:none;">
        <div class="row align-items-end">
            <div class="col-md-3 mb-3">
                <label>Number Of Shelves</label>
                <input type="number" class="modern-input shelfCount" value="1" min="1">
            </div>
            <div class="col-md-3 mb-3">
                <button type="button" class="generate-btn" onclick="generateShelves(this)">Generate Shelves</button>
            </div>
        </div>
        <div class="shelfInputs"></div>
    </div>
</div>