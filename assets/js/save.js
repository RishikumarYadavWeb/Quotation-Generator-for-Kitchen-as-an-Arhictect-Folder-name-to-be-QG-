async function saveQuotation(){
    const form = document.getElementById( 'quotationForm');
    const formData = new FormData(form);
    const quotationData = {};
    formData.forEach((value,key)=>{quotationData[key] = value;});
    quotationData.total_sqft = document.getElementById('totalSqft' )?.value || 0;
    quotationData.grand_total = document.getElementById('grandTotal' )?.value || 0;
    quotationData.packing_charge = document.getElementById('packingCharge' )?.value || 0;
    quotationData.installation_charge = document.getElementById('installationCharge' )?.value || 0;
    quotationData.special_discount = document.getElementById('specialDiscount' )?.value || 0;
    quotationData.final_customer_price = document.getElementById('finalCustomerPrice' )?.value || 0;
    quotationData.elevations = [];
    quotationData.drawers = [];
    quotationData.shelves = [];
    quotationData.standardAccessories = [];
    try{
        document
        .querySelectorAll('.elevation-card')
        .forEach((elevation,index)=>{
            const imageInput = elevation.querySelector('.line-image-input');
            const show_note = elevation.querySelector('.elevationNoteToggle')?.value || 0;
            const elevation_note = elevation.querySelector('.elevationNote')?.value || '';
            const elevationData = {
                elevation_no: index + 1,
                ceiling_height_mm: elevation.querySelector('.ceilingHeightMM')?.value || 0,
                ceiling_height_ft: elevation.querySelector('.ceilingHeightFT')?.value || 0,
                show_note,
                elevation_note,
                units: [],
                line_images: []
            };
            if (imageInput && window.elevationImages.has(imageInput)) {
                elevationData.line_images =
                    window.elevationImages
                        .get(imageInput)
                        .map(file => file.name);
            }
            const rows = elevation.querySelectorAll('.tallRow, .upperRow, .bottomRow, .loftRow');
            let unitCounters = {Tall: 0,Upper: 0,Bottom: 0,Loft: 0};
            rows.forEach(row => {
                let unitType = '';
                if(row.classList.contains('tallRow')){
                    unitType = 'Tall';
                }
                if(row.classList.contains('upperRow')){
                    unitType = 'Upper';
                }
                if(row.classList.contains('bottomRow')){
                    unitType = 'Bottom';
                }
                if(row.classList.contains('loftRow')){
                    unitType = 'Loft';
                }
                unitCounters[unitType]++;
                const unitGrandTotalField = row.querySelector('.unitGrandTotal');
                const master = row.closest( '.tall-master, .upper-master, .bottom-master, .loft-master');
                elevationData.units.push({
                    unit_no: unitCounters[unitType],
                    unit_key: 'E' + (index + 1) + '_' + unitType + '_' + unitCounters[unitType],
                    unit_type: unitType,
                    width_mm: row.querySelector('.widthMM')?.value || '',
                    width_ft: row.querySelector('.widthFT')?.value || '',
                    height_mm: row.querySelector('.heightMM')?.value || '',
                    height_ft: row.querySelector('.heightFT')?.value || '',
                    depth_mm: row.querySelector('.depthMM')?.value || '',
                    sqft: row.querySelector('.sqft')?.value || '',
                    carcass_categories_id: row.querySelector('.carcassCategory')?.value || '',
                    carcass_materials_id: row.querySelector('.carcassMaterial')?.value || '',
                    carcass_total: row.querySelector('.carcassTotal')?.value || '',
                    shutter_categories_id: row.querySelector('.shutterCategory')?.value || '',
                    shutter_materials_id: row.querySelector('.shutterSubMaterial')?.value || '',
                    shutter_total: row.querySelector('.shutterTotal')?.value || '',
                    unit_total: '0',
                    drawers:[],
                    shelves:[]
                });
                const currentUnit = elevationData.units[elevationData.units.length - 1];
            });
            quotationData.elevations.push(elevationData);
        });
        const visiblePanels = [];
        document.querySelectorAll('.panelRow')
        .forEach(row => {
            visiblePanels.push({
                width_mm: row.querySelector('.panelWidth')?.value || 0,
                height_mm: row.querySelector('.panelHeight')?.value || 0,
                sqft: row.querySelector('.panelSqft')?.value || 0,
                category_id: row.querySelector('.panelCategory')?.value || 0,
                material_id: row.querySelector('.panelMaterial')?.value || 0,
                panel_price: row.querySelector('.panelPrice')?.value || 0
            });
        });
        quotationData.visiblePanels = visiblePanels;
        const visibleSidePanels = [];
        document.querySelectorAll('.sidePanelRow')
        .forEach(row => {
            visibleSidePanels.push({
                width_mm: row.querySelector('.sidePanelWidth')?.value || 0,
                height_mm: row.querySelector('.sidePanelHeight')?.value || 0,
                sqft: row.querySelector('.sidePanelSqft')?.value || 0,
                category_id: row.querySelector('.sidePanelCategory')?.value || 0,
                material_id: row.querySelector('.sidePanelMaterial')?.value || 0,
                panel_price: row.querySelector('.sidePanelPrice')?.value || 0
            });
        });
        quotationData.visibleSidePanels = visibleSidePanels;
        quotationData.accessories = [];
        document
        .querySelectorAll('.accessoryRow')
        .forEach(row => {
            const category = row.querySelector('.accessoryCategory')?.value || '';
            const accessoryId = row.querySelector('.accessorySelect')?.value || 0;
            const otherMaterial = row.querySelector('.accessoryOtherMaterial')?.value || '';
            quotationData.accessories.push({
                category_id: category,
                accessory_id: accessoryId,
                other_material: otherMaterial,
                qty: row.querySelector('.accessoryQty')?.value || 0,
                price: row.querySelector('.accessoryPrice')?.value || 0,
                total: row.querySelector('.accessoryTotal')?.value || 0
            });
        });
        const standardAccessories = [];
        document
        .querySelectorAll('.standardAccessoryRow')
        .forEach(row => {
            const materialId = row.querySelector('.standardAccessoryMaterial')?.value;
            if(!materialId) return;
            standardAccessories.push({
                standard_accessory_id: materialId,
                qty: row.querySelector('.standardAccessoryQty')?.value || 0,
                unit_price: row.querySelector('.standardAccessoryPrice')?.value || 0,
                total_price: row.querySelector('.standardAccessoryTotal')?.value || 0
            });
        });
        quotationData.standard_accessories = standardAccessories;
        document
        .querySelectorAll('.shelfTableBody tr')
        .forEach(shelf => {
            quotationData.shelves.push({
                assigned_unit_id: shelf.querySelector( '.shelfAssignedUnit' )?.value || '',
                quantity: shelf.querySelector('.shelfQty')?.value || '1',
                shelf_categories_id: shelf.querySelector('.shelfCategory')?.value || 0,
                shelf_materials_id: shelf.querySelector('.shelfMaterial')?.value || 0,
                width_mm: shelf.querySelector('.shelfWidthMM')?.value || 0,
                width_ft: shelf.querySelector('.shelfWidthFT')?.value || 0,
                height_mm: shelf.querySelector('.shelfHeightMM')?.value || 0,
                height_ft: shelf.querySelector('.shelfHeightFT')?.value || 0,
                price: shelf.querySelector('.shelfPrice')?.value || 0,
                total: shelf.querySelector('.shelfTotal')?.value || 0
            });
        });
        document
            .querySelectorAll('.drawerTableBody tr')
            .forEach(drawer => {
                quotationData.drawers.push({
                    assigned_unit_id: drawer.querySelector('.drawerAssignedUnit')?.value || '',
                    quantity: drawer.querySelector('.drawerQty')?.value || '1',
                    drawer_categories_id: drawer.querySelector('.drawerCategory')?.value || '',
                    drawer_materials_id: drawer.querySelector('.drawerMaterial')?.value || '',
                    width_mm: drawer.querySelector('.drawerWidthMM')?.value || '',
                    width_ft: drawer.querySelector('.drawerWidthFT')?.value || '',
                    height_mm: drawer.querySelector('.drawerHeightMM')?.value || '',
                    height_ft: drawer.querySelector('.drawerHeightFT')?.value || '',
                    price: drawer.querySelector('.drawerPrice')?.value || '',
                    total: drawer.querySelector('.drawerTotal')?.value || ''
                });
            });
        quotationData.elevations.forEach(elevation => {
            elevation.units.forEach(unit => {
                let unitTotal = 0;
                const carcass = parseFloat(String(unit.carcass_total).replace(/[₹,\s]/g,'')) || 0;
                const shutter = parseFloat(String(unit.shutter_total).replace(/[₹,\s]/g,'')) || 0;
                unitTotal = carcass + shutter;
                quotationData.drawers.forEach(drawer => {
                    if(
                        drawer.assigned_unit_id === unit.unit_key
                    ){
                        unitTotal += parseFloat( String(drawer.total) .replace(/[₹,\s]/g,'')) || 0;
                    }
                });
                quotationData.shelves.forEach(shelf => {
                    if(
                        shelf.assigned_unit_id === unit.unit_key
                    ){
                        unitTotal += parseFloat( String(shelf.total) .replace(/[₹,\s]/g,'')) || 0;
                    }
                });
                unit.unit_total = unitTotal.toFixed(2);
            });
        });
        const imageUploadResponse = await fetch(BASE_URL + 'ajax/upload-elevation-images.php',);
        const projectImageFormData = new FormData();
        PROJECT_IMAGES.render.forEach(file=>{
            projectImageFormData.append("render_images[]",file);
        });
        PROJECT_IMAGES.floorplan.forEach(file=>{
            projectImageFormData.append("floorplan_images[]",file);
        });
        Object.keys(PROJECT_IMAGES.elevations).forEach(index=>{
            PROJECT_IMAGES.elevations[index].forEach(file=>{
                projectImageFormData.append(`elevation_images[${index}][]`,file);
            });
        });
        const projectImageUploadResponse=await fetch(
            BASE_URL+"ajax/upload-project-images.php",
            {
                method:"POST",
                body:projectImageFormData
            }
        );
        const projectImageResult=await projectImageUploadResponse.json();
        quotationData.project_images=projectImageResult.images;
        const response =
            await fetch(
                BASE_URL + 'ajax/save-quotation.php',
                {
                    method:'POST',
                    headers:{'Content-Type': 'application/json'},
                    body:JSON.stringify(quotationData)
                }
            );
        // const text = await response.text();
        // console.log(text);
        // return;
        const result = await response.json();
        if(result.status){
            alert('Quotation Saved Successfully');
            window.location.href = 'view.php?id=' + result.quotation_id;
        }else{
            alert(result.message || 'Failed To Save Quotation');
        }
    }catch(error){
        console.error(error);
    }
}