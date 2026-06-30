function toggleDrawerSection(radio){
    const wrapper = radio.closest('.drawer-wrapper');
    const section = wrapper.querySelector('.drawer-section');
    section.style.display = radio.value === 'yes' ? 'block' : 'none';
}
async function generateDrawers(button){
    const section = button.closest('.drawer-section');
    const count = parseInt(section.querySelector('.drawerCount').value) || 0;
    const container = section.querySelector('.drawerInputs');
    let table = container.querySelector('.drawer-table-wrapper');
    if(!table){
        const response = await fetch(BASE_URL + 'ajax/drawer-table.php');
        const html = await response.text();
        container.innerHTML = html;
        table = container.querySelector('.drawer-table-wrapper');
    }
    const tbody = table.querySelector('.drawerTableBody');
    const existingRows = tbody.querySelectorAll('tr');
    if(count > existingRows.length){
        const rowsToAdd = count - existingRows.length;
        for(let i=0;i<rowsToAdd;i++){
            tbody.insertAdjacentHTML('beforeend',getDrawerRow());
            const lastRow = tbody.querySelector('tr:last-child');
            loadDrawerCategories(lastRow);
        }
    }
    else if(count < existingRows.length){
        for(
            let i = existingRows.length - 1;
            i >= count;
            i--
        ){
            existingRows[i].remove();
        }
    }
    const master = button.closest('.tall-master, .upper-master, .bottom-master, .loft-master');
    refreshUnitDropdowns(master);
}
function loadDrawerMaterials(select){
    return $.ajax({
        url:'/QG/ajax/get-drawer-materials.php',
        type:'POST',
        data:{category_id: select.value},
        success:function(response){
            const row = select.closest('tr');
            const materialDropdown = row.querySelector('.drawerMaterial');
            materialDropdown.innerHTML = '<option value="">Select Material</option>'+ response;
        }
    });
}
function convertDrawerMMFT(input){
    const drawer = input.closest('tr');
    if(!drawer) return;
    const widthMMField = drawer.querySelector('.drawerWidthMM');
    const depthMMField = drawer.querySelector('.drawerHeightMM');
    const widthFTField = drawer.querySelector('.drawerWidthFT');
    const depthFTField = drawer.querySelector('.drawerHeightFT');
    if( !widthMMField || !depthMMField || !widthFTField || !depthFTField ){
        return;
    }
    const widthMM = parseFloat(widthMMField.value) || 0;
    const depthMM = parseFloat(depthMMField.value) || 0;
    const widthFT = widthMM / 304.8;
    const depthFT = depthMM / 304.8;
    widthFTField.value = widthFT.toFixed(2);
    depthFTField.value = depthFT.toFixed(2);
}
function convertDrawerFTMM(input){
    const drawer = input.closest('tr');
    if(!drawer) return;
    const widthFTField = drawer.querySelector('.drawerWidthFT');
    const depthFTField = drawer.querySelector('.drawerHeightFT');
    const widthMMField = drawer.querySelector('.drawerWidthMM');
    const depthMMField = drawer.querySelector('.drawerHeightMM');
    if( !widthFTField || !depthFTField || !widthMMField || !depthMMField){
        return;
    }
    const widthFT = parseFloat(widthFTField.value) || 0;
    const depthFT = parseFloat(depthFTField.value) || 0;
    const widthMM = widthFT * 304.8;
    const depthMM = depthFT * 304.8;
    widthMMField.value = widthMM.toFixed(0);
    depthMMField.value = depthMM.toFixed(0);
}
function calculateDrawerPrice(select){
    const row = select.closest('tr');
    if(!row) return;
    const option = select.options[select.selectedIndex];
    const price = parseFloat(option.dataset.price) || 0;
    const priceField = row.querySelector('.drawerPrice');
    if(priceField){
        priceField.value = (price * getCostMultiplier()).toFixed(2);
    }
    calculateDrawerTotal(row);
}
function calculateDrawerTotal(drawer){
    if(!drawer) return;
    const priceField = drawer.querySelector('.drawerPrice');
    const qtyField = drawer.querySelector('.drawerQty');
    const totalField = drawer.querySelector('.drawerTotal');
    if(
        !priceField || !qtyField || !totalField
    ){
        return;
    }
    const price = parseFloat(priceField.value) || 0;
    const qty = parseFloat(qtyField.value) || 0;
    const total = price * qty;
    totalField.value = '₹ ' + total.toFixed(2);
    const unit = drawer.closest('.generated-unit');
    if(unit){
        calculateGrandUnitTotal(unit);
    }
}
function updateDrawerGrandTotal(){
    let total = 0;
    document
    .querySelectorAll('.drawerTotal')
    .forEach(field => {
        total += parseFloat(field.value) || 0;
    });
}
function getDrawerRow(){
    return `
        <tr>
            <td>
                <select class="modern-input drawerAssignedUnit">
                    <option value="">Select Unit</option>
                </select>
            </td>
            <td><input type="number" class="modern-input drawerQty" value="1" min="1" oninput="calculateDrawerTotal(this.closest('tr'))" ></td>
            <td><input type="number" class="modern-input drawerWidthMM" oninput="convertDrawerMMFT(this)" min="0"></td>
            <td><input type="number" class="modern-input drawerWidthFT" oninput="convertDrawerFTMM(this)" min="0"></td>
            <td><input type="number" class="modern-input drawerHeightMM" oninput="convertDrawerMMFT(this)" min="0"></td>
            <td><input type="number" class="modern-input drawerHeightFT" oninput="convertDrawerFTMM(this)" min="0"></td>
            <td>
                <select class="modern-input drawerCategory" onchange="loadDrawerMaterials(this)" >
                    <option value="">Loading...</option>
                </select>
            </td>
            <td>
                <select class="modern-input drawerMaterial" onchange="calculateDrawerPrice(this)">
                    <option value="">Select Material</option>
                </select>
            </td>
            <td>
                <input type="text" class="modern-input drawerTotal" readonly >
                <input type="hidden" class="drawerPrice" >
            </td>
        </tr>
    `;
}
function loadDrawerCategories(row){
    const categoryDropdown = row.querySelector('.drawerCategory');
    $.ajax({
        url:'/QG/ajax/get-drawer-categories.php',
        type:'GET',
        success:function(response){
            categoryDropdown.innerHTML = '<option value="">Select Category</option>' + response;
        }
    });
}