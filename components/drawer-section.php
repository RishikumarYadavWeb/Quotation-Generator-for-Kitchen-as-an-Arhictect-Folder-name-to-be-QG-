<div class="drawer-wrapper mt-4">
    <div class="generated-title">Drawers</div>
    <label>Does it have drawers?</label>
    <div class="d-flex gap-3 mb-3">
        <label><input type="radio" name="drawerOption" value="yes" onchange="toggleDrawerSection(this)">Yes</label>
        <label><input type="radio" name="drawerOption" value="no" checked onchange="toggleDrawerSection(this)">No</label>
    </div>
    <div class="drawer-section" style="display:none;">
        <div class="row align-items-end">
            <div class="col-md-3">
                <label>Number Of Drawers</label>
                <input type="number" class="modern-input drawerCount" value="1" min="1">
            </div>
            <div class="col-md-3">
                <button type="button" class="generate-btn" onclick="generateDrawers(this)">Generate Drawers</button>
            </div>
        </div>
        <div class="drawerInputs"></div>
    </div>
</div>