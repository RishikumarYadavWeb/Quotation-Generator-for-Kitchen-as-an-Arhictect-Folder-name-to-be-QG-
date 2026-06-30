async function generateUnits(button, type){
    if(type === 'Tall'){
        await generateTallUnits(button,type);
        return;
    }
    if(type === 'Upper'){
        await generateUpperUnits(button,type);
        return;
    }
    if(type === 'Bottom'){
        await generateBottomUnits(button,type);
        return;
    }
    if(type === 'Loft'){
        await generateLoftUnits(button,type);
        return;
    }
    const wrapper = button.closest('.unit-wrapper');
    const count = parseInt(wrapper.querySelector('input[type="number"]').value) || 0;
    const elevation = button.closest('.elevation-card');
    if(!elevation) return;
    const container = elevation.querySelector(`.${type.toLowerCase()}Container`);
    if(!container) return;
    const existingUnits = container.querySelectorAll('.generated-unit');
    if(count > existingUnits.length){
        const newUnits = count - existingUnits.length;
        const response =
            await fetch(
                BASE_URL +
                'ajax/create-unit.php',
                {
                    method:'POST',
                    headers:{'Content-Type': 'application/x-www-form-urlencoded'},
                    body:`type=${type}`
                }
            );
        const html = await response.text();
        const fragment = document.createDocumentFragment();
        for(let i = 0; i < newUnits; i++){
            const div = document.createElement('div');
            div.innerHTML = html;
            const generatedUnit = div.firstElementChild;
            generatedUnit.dataset.unitType = type;
        }
        container.appendChild(fragment);
    }
    else if(count < existingUnits.length){
        for(
            let i = existingUnits.length - 1;
            i >= count;
            i--
        ){
            existingUnits[i].remove();
        }
    }
    updateGrandTotal();
}
function getNumber(value){
    return parseFloat(String(value).replace(/[^\d.-]/g, '')) || 0;
}
function calculateGrandUnitTotal(unit){
    if(!unit) return;
    let carcassTotal = 0;
    let shutterTotal = 0;
    let drawerTotal = 0;
    let shelfTotal = 0;
    unit
    .querySelectorAll('.carcassTotal')
    .forEach(field => {
        const value = getNumber(field.value);
        carcassTotal += value;
    });
    unit
    .querySelectorAll('.shutterTotal')
    .forEach(field => {
        const value = getNumber(field.value);
        shutterTotal += value;
    });
    unit
    .querySelectorAll('.drawerTotal')
    .forEach(field => {
        const value = getNumber(field.value);
        drawerTotal += value;
    });
    unit
    .querySelectorAll('.shelfTotal')
    .forEach(field => {
        const value = getNumber(field.value);
        shelfTotal += value;
    });
    const total = carcassTotal + shutterTotal + drawerTotal + shelfTotal;
    const totalField = unit.querySelector('.unitGrandTotal');
    if(totalField){
        totalField.value = '₹ ' + total.toFixed(2);
    }
    updateGrandTotal();
}
async function generateTallUnits(button,type){
    const wrapper = button.closest('.unit-wrapper');
    const count = parseInt(wrapper.querySelector('input[type="number"]').value) || 0;
    const elevation = button.closest('.elevation-card');
    const container = elevation.querySelector('.tallContainer');
    let master =  container.querySelector('.tall-master');
    if(!master){
        const response =
            await fetch(
                BASE_URL +
                'ajax/create-unit.php',
                {
                    method:'POST',
                    headers:{'Content-Type': 'application/x-www-form-urlencoded'},
                    body:'type=Tall'
                }
            );
        container.innerHTML = await response.text();
        master = container.querySelector('.tall-master');
    }
    const tbody = master.querySelector('.tallRows');
    let existingRows = tbody.querySelectorAll('.tallRow');
    if(count > existingRows.length){
        const rowsToAdd = count - existingRows.length;
        const rowResponse = await fetch( BASE_URL + 'ajax/create-tall-row.php');
        const rowHtml = await rowResponse.text();
        for(
            let i = 0;
            i < rowsToAdd;
            i++
        ){
            const temp = document.createElement('tbody');
            temp.innerHTML = rowHtml;
            tbody.appendChild(temp.firstElementChild);
        }
    }
    else if(
        count <
        existingRows.length
    ){
        for(
            let i = existingRows.length - 1;
            i >= count;
            i--
        ){
            existingRows[i].remove();
        }
    }
    renumberTallRows(elevation);
    refreshUnitDropdowns();
}
function renumberTallRows(elevation){
    const elevationNo = Array.from(document.querySelectorAll('.elevation-card')).indexOf(elevation) + 1;
    elevation
    .querySelectorAll('.tallRow')
    .forEach((row,index)=>{
        row.dataset.unitKey = `E${elevationNo}_Tall_${index + 1}`;
        row.querySelector('.srNo').innerText = index + 1;
        row.querySelector('.description').innerText = 'Tall Unit ' + (index + 1);
        if(
            !row.querySelector('.carcassCategory')
        ){
            const carcassHTML = document.querySelector('#carcassCategoryTemplate').innerHTML;
            row.querySelector(
                '.carcassCategoryCell'
            ).innerHTML =
                `<select class="modern-input carcassCategory"
                    onchange="loadCarcassMaterials(this)">
                    ${carcassHTML}
                </select>`;
        }
        if(
            !row.querySelector('.shutterCategory')
        ){
            const shutterHTML =
                document.querySelector(
                    '#shutterCategoryTemplate'
                ).innerHTML;

            row.querySelector(
                '.shutterCategoryCell'
            ).innerHTML =
                `<select class="modern-input shutterCategory"
                    onchange="loadShutterMaterials(this)">
                    ${shutterHTML}
                </select>`;
        }
    });
}
async function generateUpperUnits(button,type){
    const wrapper = button.closest('.unit-wrapper');
    const count = parseInt(wrapper.querySelector('input[type="number"]').value) || 0;
    const elevation = button.closest('.elevation-card');
    const container = elevation.querySelector('.upperContainer');
    let master = container.querySelector('.upper-master');
    if(!master){
        const response =
            await fetch(
                BASE_URL +
                'ajax/create-unit.php',
                {
                    method:'POST',
                    headers:{'Content-Type':'application/x-www-form-urlencoded'},
                    body:'type=Upper'
                }
            );
        container.innerHTML = await response.text();
        master = container.querySelector( '.upper-master' );
    }
    const tbody = master.querySelector('.upperRows');
    let existingRows = tbody.querySelectorAll('.upperRow');
    if(count > existingRows.length){
        const rowsToAdd = count - existingRows.length;
        const rowResponse = await fetch( BASE_URL + 'ajax/create-upper-row.php');
        const rowHtml =  await rowResponse.text();
        for(
            let i = 0;
            i < rowsToAdd;
            i++
        ){
            const temp = document.createElement('tbody');
            temp.innerHTML = rowHtml;
            tbody.appendChild(temp.firstElementChild);
        }
    }
    else if(
        count < existingRows.length
    ){
        for(
            let i = existingRows.length - 1;
            i >= count;
            i--
        ){
            existingRows[i].remove();
        }
    }
    renumberUpperRows(elevation);
    updateGrandTotal();
    refreshUnitDropdowns();
}
function renumberUpperRows(elevation){
    const elevationNo = Array.from(document.querySelectorAll('.elevation-card')).indexOf(elevation) + 1;
    elevation
    .querySelectorAll('.upperRow')
    .forEach((row,index)=>{
        row.dataset.unitKey = `E${elevationNo}_Upper_${index + 1}`;
        row.querySelector('.srNo').innerText = index + 1;
        row.querySelector('.description').innerText = 'Upper Unit ' + (index + 1);
        if(
            !row.querySelector('.carcassCategory')
        ){
            const carcassHTML = document.querySelector('#upperCarcassCategoryTemplate').innerHTML;
            row.querySelector(
                '.carcassCategoryCell'
            ).innerHTML =
                `<select class="modern-input carcassCategory" onchange="loadCarcassMaterials(this)">
                    ${carcassHTML}
                </select>`;
        }
        if(
            !row.querySelector('.shutterCategory')
        ){
            const shutterHTML = document.querySelector('#upperShutterCategoryTemplate').innerHTML;
            row.querySelector(
                '.shutterCategoryCell'
            ).innerHTML =
                `<select class="modern-input shutterCategory" onchange="loadShutterMaterials(this)">
                    ${shutterHTML}
                </select>`;
        }
    });
}
async function generateBottomUnits(button,type){
    const wrapper = button.closest('.unit-wrapper');
    const count = parseInt(wrapper.querySelector('input[type="number"]').value) || 0;
    const elevation = button.closest('.elevation-card');
    const container = elevation.querySelector('.bottomContainer');
    let master = container.querySelector('.bottom-master');
    if(!master){
        const response =
            await fetch(
                BASE_URL +
                'ajax/create-unit.php',
                {
                    method:'POST',
                    headers:{'Content-Type': 'application/x-www-form-urlencoded'},
                    body:'type=Bottom'
                }
            );
        container.innerHTML = await response.text();
        master = container.querySelector('.bottom-master');
    }
    const tbody = master.querySelector('.bottomRows');
    let existingRows = tbody.querySelectorAll('.bottomRow');
    if(count > existingRows.length){
        const rowsToAdd = count - existingRows.length;
        const rowResponse = await fetch( BASE_URL + 'ajax/create-bottom-row.php');
        const rowHtml = await rowResponse.text();
        for(
            let i = 0;
            i < rowsToAdd;
            i++
        ){
            const temp = document.createElement('tbody');
            temp.innerHTML = rowHtml;
            tbody.appendChild( temp.firstElementChild);
        }
    }
    else if(
        count < existingRows.length
    ){
        for(
            let i = existingRows.length - 1;
            i >= count;
            i--
        ){
            existingRows[i].remove();
        }
    }
    renumberBottomRows(elevation);
    updateGrandTotal();
    refreshUnitDropdowns();
}
function renumberBottomRows(elevation){
    const elevationNo = Array.from(document.querySelectorAll('.elevation-card')).indexOf(elevation) + 1;
    elevation
    .querySelectorAll('.bottomRow')
    .forEach((row,index)=>{
        row.dataset.unitKey = `E${elevationNo}_Bottom_${index + 1}`;
        row.querySelector('.srNo').innerText = index + 1;
        row.querySelector('.description').innerText = 'Bottom Unit ' + (index + 1);
        if(
            !row.querySelector('.carcassCategory')
        ){
            const carcassHTML = document.querySelector( '#bottomCarcassCategoryTemplate').innerHTML;
            row.querySelector(
                '.carcassCategoryCell'
            ).innerHTML =
                `<select class="modern-input carcassCategory" onchange="loadCarcassMaterials(this)">
                    ${carcassHTML}
                </select>`;
        }
        if(
            !row.querySelector('.shutterCategory')
        ){
            const shutterHTML = document.querySelector('#bottomShutterCategoryTemplate').innerHTML;
            row.querySelector(
                '.shutterCategoryCell'
            ).innerHTML =
                `<select class="modern-input shutterCategory" onchange="loadShutterMaterials(this)">
                    ${shutterHTML}
                </select>`;
        }
    });
}
async function generateLoftUnits(button,type){
    const wrapper = button.closest('.unit-wrapper');
    const count = parseInt( wrapper.querySelector('input[type="number"]').value) || 0;
    const elevation = button.closest('.elevation-card');
    const container = elevation.querySelector('.loftContainer');
    let master = container.querySelector('.loft-master');
    if(!master){
        const response =
            await fetch(
                BASE_URL +
                'ajax/create-unit.php',
                {
                    method:'POST',
                    headers:{'Content-Type': 'application/x-www-form-urlencoded'},
                    body:'type=Loft'
                }
            );
        container.innerHTML = await response.text();
        master = container.querySelector( '.loft-master' );
    }
    const tbody = master.querySelector('.loftRows');
    let existingRows = tbody.querySelectorAll('.loftRow');
    if(count > existingRows.length){
        const rowsToAdd = count - existingRows.length;
        const rowResponse = await fetch( BASE_URL + 'ajax/create-loft-row.php' );
        const rowHtml = await rowResponse.text();
        for(let i = 0; i < rowsToAdd; i++){
            const temp = document.createElement('tbody');
            temp.innerHTML = rowHtml;
            tbody.appendChild(temp.firstElementChild);
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
    renumberLoftRows(elevation);
    updateGrandTotal();
    refreshUnitDropdowns();
}
function renumberLoftRows(elevation){
    const elevationNo = Array.from(document.querySelectorAll('.elevation-card')).indexOf(elevation) + 1;
    elevation
    .querySelectorAll('.loftRow')
    .forEach((row,index)=>{
        row.dataset.unitKey = `E${elevationNo}_Loft_${index + 1}`;
        row.querySelector('.srNo').innerText = index + 1;
        row.querySelector('.description').innerText = 'Loft Unit ' + (index + 1);
        if(
            !row.querySelector('.carcassCategory')
        ){
            const carcassHTML = document.querySelector( '#loftCarcassCategoryTemplate' ).innerHTML;
            row.querySelector(
                '.carcassCategoryCell'
            ).innerHTML =
                `<select class="modern-input carcassCategory" onchange="loadCarcassMaterials(this)">
                    ${carcassHTML}
                </select>`;
        }
        if(
            !row.querySelector('.shutterCategory')
        ){
            const shutterHTML = document.querySelector('#loftShutterCategoryTemplate').innerHTML;
            row.querySelector(
                '.shutterCategoryCell'
            ).innerHTML =
                `<select class="modern-input shutterCategory" onchange="loadShutterMaterials(this)">
                    ${shutterHTML}
                </select>`;
        }
    });
}