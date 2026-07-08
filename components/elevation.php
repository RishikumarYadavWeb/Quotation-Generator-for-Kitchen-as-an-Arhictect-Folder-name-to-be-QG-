<div class="main-card elevation-card mb-4">
    <div class="title-flex mb-4" style="display:flex;align-items:center;justify-content:space-between;gap:20px;">
        <div style="display:flex;align-items:center;gap:15px;">
            <div class="circle-number elevationNumber">Elevation</div>
            <h4 class="elevationTitle" style="margin:0;">Elevation</h4>
        </div>
        <div style="display:flex;align-items:center;gap:10px;">
            <label style="margin:0;font-weight:600;">Add Note</label>
            <select class="form-control elevationNoteToggle" style="width:100px;" onchange="toggleElevationNote(this)">
                <option value="0" selected>No</option>
                <option value="1">Yes</option>
            </select>
        </div>
    </div>
    <div class="elevationNoteWrapper" style="display:none;margin-top:-10px;margin-bottom:20px;">
        <input type="text" class="form-control elevationNote" placeholder="Enter Elevation Note">
    </div>
    <div class="row mb-4 mt-3">
        <div class="col-md-6">
            <label>Ceiling Height MM</label>
            <input type="number" min="0" class="modern-input ceilingHeightMM" placeholder="Enter MM" oninput="convertCeilingMMFT(this)">
        </div>
        <div class="col-md-6">
            <label> Ceiling Height FT </label>
            <input type="number" min="0" class="modern-input ceilingHeightFT" placeholder="Enter FT" oninput="convertCeilingFTMM(this)">
        </div>
    </div>
    <div class="unit-wrapper">
        <div class="unit-title">Base Units</div>
        <div class="row mb-4 align-items-end">
            <div class="col-md-4">
                <label>Number Of Units</label>
                <input type="number" class="modern-input bottomUnitCount" value="0" min="0">
            </div>
            <div class="col-md-3">
                <button type="button" onclick="generateUnits(this,'Bottom')" class="generate-btn">Generate Bottom Units</button>
            </div>
        </div>
        <div class="bottomContainer"></div>
    </div>
    <div class="unit-wrapper" data-unit-type="Tall">
        <div class="unit-title">Wall Units</div>
        <div class="row mb-4 align-items-end">
            <div class="col-md-4">
                <label>Number Of Units</label>
                <input type="number" class="modern-input upperUnitCount" value="0" min="0">
            </div>
            <div class="col-md-3">
                <button type="button" onclick="generateUnits(this,'Upper')" class="generate-btn" >Generate Upper Units</button>
            </div>
        </div>
        <div class="upperContainer"></div>
    </div>
    <div class="unit-wrapper">
        <div class="unit-title">Tall Units</div>
        <div class="row mb-4 align-items-end">
            <div class="col-md-4">
                <label> Number Of Units </label>
                <input type="number" class="modern-input tallUnitCount" value="0" min="0">
            </div>
            <div class="col-md-3">
                <button type="button" onclick="generateUnits(this,'Tall')" class="generate-btn">Generate Tall Units</button>
            </div>
        </div>
        <div class="tallContainer"></div>
    </div>
    <div class="unit-wrapper">
        <div class="unit-title">Loft Units</div>
        <div class="row mb-4 align-items-end">
            <div class="col-md-4">
                <label>Number Of Units</label>
                <input type="number" class="modern-input loftUnitCount" value="0" min="0">
            </div>
            <div class="col-md-3">
                <button type="button" onclick="generateUnits(this,'Loft')" class="generate-btn">Generate Loft Units</button>
            </div>
        </div>
        <div class="loftContainer"></div>
    </div>
</div>