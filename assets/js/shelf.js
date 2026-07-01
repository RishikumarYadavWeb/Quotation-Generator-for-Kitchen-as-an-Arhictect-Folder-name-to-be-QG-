function toggleShelfSection(radio){
    const wrapper = radio.closest('.shelf-wrapper');
    const section = wrapper.querySelector('.shelf-section');
    section.style.display = radio.value === 'yes' ? 'block' : 'none';
}
function toggleFrontType(select){
    const row = select.closest('.bottomRow');
    if(!row) return;
    const shutterCategory = row.querySelector('.shutterCategory');
    const shutterMaterial = row.querySelector('.shutterSubMaterial');
    const shutterTotal = row.querySelector('.shutterTotal');
    if(select.value === 'drawer'){
        if(shutterCategory){
            shutterCategory.value = '';
            shutterCategory.disabled = true;
        }
        if(shutterMaterial){
            shutterMaterial.innerHTML = '<option value="">Select Material</option>';
            shutterMaterial.disabled = true;
        }
        if(shutterTotal){
            shutterTotal.value = '₹ 0.00';
        }
        updateRowTotal(row);
    }
    else{
        if(shutterCategory){
            shutterCategory.disabled = false;
        }
        if(shutterMaterial){
            shutterMaterial.disabled = false;
        }
    }
}
async function generateShelves(button){
    const wrapper = button.closest('.shelf-wrapper');
    const count = parseInt(wrapper.querySelector('.shelfCount').value) || 0;
    const container = wrapper.querySelector('.shelfInputs');
    let table = container.querySelector('.shelf-table-wrapper');
    if(!table){
        const response = await fetch(BASE_URL + 'ajax/shelf-table.php');
        const html = await response.text();
        container.innerHTML = html;
        table = container.querySelector('.shelf-table-wrapper');
    }
    const tbody = table.querySelector('.shelfTableBody');
    const existingRows = tbody.querySelectorAll('tr');
    if(count > existingRows.length){
        const rowsToAdd = count - existingRows.length;
        for(let i=0;i<rowsToAdd;i++){
            tbody.insertAdjacentHTML('beforeend',getShelfRow());
            const row = tbody.querySelector('tr:last-child');
            loadShelfCategories(row);
            let depth = 350;
            const generatedUnit = button.closest('.generated-unit');
            if(
                generatedUnit && (generatedUnit.classList.contains('tall-master') || generatedUnit.classList.contains('bottom-master'))
            ){
                depth = 600;
            }
            const depthField = row.querySelector('.shelfHeightMM');
            if(depthField){
                depthField.value = depth;
                convertShelfMMFT(depthField);
            }
        }
    }
    else if(count < existingRows.length){
        for(
            let i=existingRows.length-1;
            i>=count;
            i--
        ){
            existingRows[i].remove();
        }
    }
    const master = button.closest('.tall-master, .upper-master, .bottom-master, .loft-master');
    refreshUnitDropdowns(master);
}
function convertShelfMMFT(input){
    const shelf = input.closest('tr');
    const widthMMField = shelf.querySelector('.shelfWidthMM');
    const heightMMField = shelf.querySelector('.shelfHeightMM');
    const widthFTField = shelf.querySelector('.shelfWidthFT');
    const heightFTField = shelf.querySelector('.shelfHeightFT');
    const widthMM = parseFloat(widthMMField.value) || 0;
    const heightMM = parseFloat(heightMMField.value) || 0;
    const widthFT = widthMM / 304.8;
    const heightFT = heightMM / 304.8;
    widthFTField.value = widthFT.toFixed(2);
    heightFTField.value = heightFT.toFixed(2);
    calculateShelfTotal(shelf);
}
function convertShelfFTMM(input){
    const shelf = input.closest('tr');
    const widthFTField = shelf.querySelector('.shelfWidthFT');
    const heightFTField = shelf.querySelector('.shelfHeightFT');
    const widthMMField = shelf.querySelector('.shelfWidthMM');
    const heightMMField = shelf.querySelector('.shelfHeightMM');
    const widthFT = parseFloat(widthFTField.value) || 0;
    const heightFT = parseFloat(heightFTField.value) || 0;
    const widthMM = widthFT * 304.8;
    const heightMM = heightFT * 304.8;
    widthMMField.value = widthMM.toFixed(0);
    heightMMField.value = heightMM.toFixed(0);
    calculateShelfTotal(shelf);
}
function getNumber(value){
    return parseFloat(String(value).replace(/[^\d.-]/g, '')) || 0;
}
function calculateShelfPrice(select){
    const row = select.closest('tr');
    if(!row) return;
    const option = select.options[select.selectedIndex];
    const price = parseFloat(option.dataset.price) || 0;
    row.querySelector('.shelfPrice').value = (price * getCostMultiplier()).toFixed(2);
    calculateShelfTotal(row);
}
function calculateShelfTotal(row){
    if(!row) return;
    const price = getNumber(row.querySelector('.shelfPrice').value);
    const qty = parseFloat(row.querySelector('.shelfQty').value) || 1;
    const total = price * qty;
    row.querySelector('.shelfTotal').value = '₹ ' + total.toFixed(2);
    const unit = row.closest('.generated-unit');
    if(unit){
        calculateGrandUnitTotal(unit);
    }
}
function updateShelfGrandTotal(){
    let total = 0;
    document
    .querySelectorAll('.shelfTotal')
    .forEach(field => {total += getNumber(field.value);});
}
function loadShelfMaterials(select){
    const category_id = select.value;
    const row = select.closest('tr');
    if(!row) return;
    const materialDropdown = row.querySelector('.shelfMaterial');
    if(!materialDropdown) return;
    $.ajax({
        url:'/QG/ajax/get-shelf-materials.php',
        type:'POST',
        data:{category_id: category_id},
        success:function(response){
            materialDropdown.innerHTML = '<option value="">Select Material</option>' + response;
        },
        error:function(error){
            console.error('Shelf Material Load Error:',error);
        }
    });
}
function loadShelfCategories(row){
    const dropdown = row.querySelector('.shelfCategory');
    let unitType = '';
    const unit = row.closest('.generated-unit');
    if(unit.classList.contains('tall-master')){
        unitType = 'Tall';
    }
    else if(unit.classList.contains('upper-master')){
        unitType = 'Upper';
    }
    else if(unit.classList.contains('bottom-master')){
        unitType = 'Bottom';
    }
    else if(unit.classList.contains('loft-master')){
        unitType = 'Loft';
    }
    $.ajax({
        url:'/QG/ajax/get-shelf-categories.php',
        type:'GET',
        data:{unit_type:unitType},
        success:function(response){
            dropdown.innerHTML = '<option value="">Select Category</option>' + response;
        }
    });
}
function getShelfRow(){
    return `
        <tr>
            <td>
                <select class="modern-input shelfAssignedUnit">
                    <option value="">Select Unit</option>
                </select>
            </td>
            <td><input type="number" class="modern-input shelfQty" value="1" min="1" oninput="calculateShelfTotal(this.closest('tr'))"></td>
            <td><input type="number" class="modern-input shelfWidthMM" oninput="convertShelfMMFT(this)" min="0"></td>
            <td><input type="number" class="modern-input shelfWidthFT" oninput="convertShelfFTMM(this)" min="0"></td>
            <td><input type="number" class="modern-input shelfHeightMM" oninput="convertShelfMMFT(this)" min="0"></td>
            <td><input type="number" class="modern-input shelfHeightFT" oninput="convertShelfFTMM(this)" min="0"></td>
            <td>
                <select class="modern-input shelfCategory" onchange="loadShelfMaterials(this)">
                    <option value="">Select Category</option>
                </select>
            </td>
            <td>
                <select class="modern-input shelfMaterial" onchange="calculateShelfPrice(this)">
                    <option value="">Select Material</option>
                </select>
            </td>
            <td><input type="text" class="modern-input shelfPrice" readonly></td>
            <td><input type="text" class="modern-input shelfTotal" readonly></td>
        </tr>
    `;
}