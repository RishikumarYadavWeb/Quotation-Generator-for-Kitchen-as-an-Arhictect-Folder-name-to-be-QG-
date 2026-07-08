const BASE_URL = '/QG/';
document.addEventListener('DOMContentLoaded',
    function(){
        const elevationField = document.getElementById('elevationCount');
        if(
            elevationField && (typeof IS_EDIT_PAGE === 'undefined' || !IS_EDIT_PAGE)
        ){
            generateElevations();
        }
    }
);
function openSidebar(){
    document
        .querySelector('.sidebar-fixed')
        .classList
        .add('active');
    document
        .querySelector('.sidebar-overlay')
        .classList
        .add('active');
}
function closeSidebar(){
    document
        .querySelector('.sidebar-fixed')
        .classList
        .remove('active');

    document
        .querySelector('.sidebar-overlay')
        .classList
        .remove('active');
}
function convertCeilingMMFT(input){
    let row = input.closest('.row');
    let mm = parseFloat( row.querySelector('.ceilingHeightMM')?.value ) || 0;
    let ft = mm * 0.00328084;
    let ftField = row.querySelector('.ceilingHeightFT');
    if(ftField){
        ftField.value = ft.toFixed(2);
    }
}
function convertCeilingFTMM(input){
    let row = input.closest('.row');
    let ft = parseFloat( row.querySelector('.ceilingHeightFT')?.value ) || 0;
    let mm = ft / 0.00328084;
    let mmField = row.querySelector('.ceilingHeightMM');
    if(mmField){
        mmField.value = mm.toFixed(0);
    }
}
function updateRowTotal(row){
    const master = row.closest( '.tall-master, .upper-master, .bottom-master, .loft-master' );
    if(master){
        calculateGrandUnitTotal( master );
    }
}
function calculateUnitSqft(input){
    const row = input.closest( '.tallRow, .upperRow, .bottomRow, .loftRow' );
    if(!row) return;
    const widthMM = getNumber( row.querySelector('.widthMM').value );
    const heightMM = getNumber( row.querySelector('.heightMM').value );
    const widthFT = widthMM / 304.8;
    const heightFT = heightMM / 304.8;
    const sqft = widthFT * heightFT;
    row.querySelector('.sqft').value = sqft.toFixed(2);
    const carcass = row.querySelector( '.carcassMaterial' );
    if(carcass){
        calculateCarcassAmount( carcass );
    }
    const shutter = row.querySelector( '.shutterSubMaterial' );
    if(shutter){
        calculateShutterAmount( shutter );
    }
    row.querySelector('.sqft').value = sqft.toFixed(2);
    updateTotalSqft();
}
function calculateCarcassAmount(select){
    if(!select) return;
    const row = select.closest('.tallRow, .upperRow, .bottomRow, .loftRow');
    if(!row) return;
    const sqft = getNumber(row.querySelector('.sqft').value);
    if(select.selectedIndex < 0){
        row.querySelector('.carcassTotal').value = '₹ 0.00';
        return;
    }
    const option = select.options[select.selectedIndex];
    if(!option){
        row.querySelector('.carcassTotal').value = '₹ 0.00';
        return;
    }
    const price = parseFloat(option.dataset.price || 0) * getCostMultiplier();
    const amount = sqft * price;
    row.querySelector('.carcassTotal').value = '₹ ' + amount.toFixed(2);
    updateRowTotal(row);
}
function calculateShutterAmount(select){
    if(!select) return;
    const row = select.closest('.tallRow, .upperRow, .bottomRow, .loftRow');
    if(!row) return;
    const frontTypeField = row.querySelector('.frontType');
    if(
        frontTypeField &&
        frontTypeField.value === 'drawer'
    ){
        row.querySelector('.shutterTotal').value = '₹ 0.00';
        updateRowTotal(row);
        return;
    }
    const sqft = getNumber(row.querySelector('.sqft').value);
    if(select.selectedIndex < 0){
        row.querySelector('.shutterTotal').value = '₹ 0.00';
        return;
    }
    const option = select.options[select.selectedIndex];
    if(!option){
        row.querySelector('.shutterTotal').value = '₹ 0.00';
        return;
    }
    const price =parseFloat(option.dataset.price || 0) * getCostMultiplier();
    const amount = sqft * price;
    row.querySelector('.shutterTotal').value = '₹ ' + amount.toFixed(2);
    updateRowTotal(row);
}
function loadCarcassMaterials(select){
    return new Promise((resolve, reject) => {
        const category_id = select.value;
        const row = select.closest('.tallRow, .upperRow, .bottomRow, .loftRow');
        if(!row){
            resolve();
            return;
        }
        const materialDropdown = row.querySelector('.carcassMaterial');
        if(!materialDropdown){
            resolve();
            return;
        }
        $.ajax({
            url: BASE_URL + 'ajax/get-carcass-materials.php',
            type: 'POST',
            data: { category_id },
            success: function(response){
                materialDropdown.innerHTML = '<option value="">Select Material</option>' +response;
                resolve();
            },
            error: function(error){
                reject(error);
            }
        });
    });
}
function loadShutterMaterials(select){
    return new Promise((resolve, reject) => {
        const categoryId = select.value;
        const row = select.closest('.tallRow, .upperRow, .bottomRow, .loftRow');
        if(!row){
            resolve();
            return;
        }
        const dropdown = row.querySelector('.shutterSubMaterial');
        if(!dropdown){
            resolve();
            return;
        }
        fetch(
            BASE_URL + 'ajax/get-shutter-materials.php',
            {
                method: 'POST',
                headers: {'Content-Type':'application/x-www-form-urlencoded'},
                body: `category_id=${categoryId}`
            }
        )
        .then(res => res.text())
        .then(data => {
            dropdown.innerHTML = '<option value="">Select Material</option>' + data;
            resolve();
        })
        .catch(error => {
            console.error(error);
            reject(error);
        });
    });
}
function refreshUnitDropdowns(master){
    if(!master) return;
    let options = '<option value="">Select Unit</option>';
    let unitType = '';
    if(master.classList.contains('tall-master')){
        unitType = 'Tall';
    }
    if(master.classList.contains('upper-master')){
        unitType = 'Upper';
    }
    if(master.classList.contains('bottom-master')){
        unitType = 'Bottom';
    }
    if(master.classList.contains('loft-master')){
        unitType = 'Loft';
    }
    const elevation = master.closest('.elevation-card');

    const elevationNo =[...document.querySelectorAll('.elevation-card')] .indexOf(elevation) + 1;
    const rows = master.querySelectorAll(`.${unitType.toLowerCase()}Row`);
    rows.forEach((row,index)=>{
        const key = `E${elevationNo}_${unitType}_${index + 1}`;
        options += `
            <option value="${key}">
                ${unitType} Unit ${index + 1}
            </option>
        `;
    });
    master
        .querySelectorAll('.drawerAssignedUnit')
        .forEach(select=>{
            const selected = select.value;
            select.innerHTML = options;
            select.value = selected;
        });
    master
        .querySelectorAll('.shelfAssignedUnit')
        .forEach(select=>{
            const selected = select.value;
            select.innerHTML = options;
            select.value = selected;
        });
}
window.elevationImages = new WeakMap();
document.addEventListener('change', function (e) {
    if (!e.target.classList.contains('line-image-input')) return;
    const input = e.target;
    const section = input.closest('.line-image-section');
    const previewContainer = section.querySelector('.line-image-preview');
    if (!elevationImages.has(input)) {
        elevationImages.set(input, []);
    }
    const storedFiles = elevationImages.get(input);
    Array.from(input.files).forEach(file => {
        storedFiles.push(file);
        const reader = new FileReader();
        reader.onload = function (ev) {
            const card = document.createElement('div');
            card.className = 'preview-card';
            card.innerHTML = `
                <img src="${ev.target.result}" class="preview-image">
                <button type="button" class="remove-preview">&times;</button>
            `;
            previewContainer.appendChild(card);
            card.querySelector('.remove-preview')
                .addEventListener('click', function () {
                    const index = Array.from(previewContainer.children) .indexOf(card);
                    storedFiles.splice(index, 1);
                    card.remove();
                });
        };
        reader.readAsDataURL(file);
    });
    input.value = '';
});
document.addEventListener('click', function (e) {
    if (!e.target.classList.contains('preview-image')) return;
    document.getElementById('largePreviewImage').src = e.target.src;
    const modal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
    modal.show();
});
document.querySelectorAll('.sidebar-dropdown > a')
.forEach(item => {
    item.addEventListener('click', function(e){
        e.preventDefault();
        const parent = this.parentElement;
        parent.classList.toggle('open');
        parent
            .querySelector('.submenu')
            .classList.toggle('show');
    });
});

const PROJECT_IMAGES= {render:[],floorplan:[],elevations:{}};
function initializeImageInput(inputId,previewId,type){
    const input=document.getElementById(inputId);
    if(!input) return;
    input.addEventListener("change",function(){
        const files=Array.from(this.files);
        files.forEach(file=>{
            const exists=PROJECT_IMAGES[type].some(existing=>
                existing.name===file.name &&
                existing.size===file.size &&
                existing.lastModified===file.lastModified
            );
            if(!exists){
                PROJECT_IMAGES[type].push(file);
            }
        });
        syncInputFiles(input,PROJECT_IMAGES[type]);
        renderPreview(type,previewId);
    });
}
function syncInputFiles(input, files){
    const dt = new DataTransfer();
    files.forEach(file=>{
        if(file instanceof File){
            dt.items.add(file);
        }
    });
    input.files = dt.files;
}
function renderPreview(type, previewId){
    const container = document.getElementById(previewId);
    if(!container) return;
    container.innerHTML = "";
    PROJECT_IMAGES[type].forEach((file,index)=>{
        if(file.image_path){
            container.innerHTML += `
                <div class="image-preview-box">
                    <img src="/QG/uploads/${file.image_path}" class="image-thumb" onclick="openImagePreview('/QG/uploads/${file.image_path}')">
                    <button type="button" class="image-delete-btn" onclick="removeExistingProjectImage('${type}',${index},${file.id})">×</button>
                </div>
            `;
            return;
        }
        const reader = new FileReader();
        reader.onload = function(e){
            container.innerHTML += `
                <div class="image-preview-box">
                    <img src="${e.target.result}" class="image-thumb" onclick="openImagePreview('${e.target.result}')">
                    <button type="button" class="image-delete-btn" onclick="removeProjectImage('${type}',${index},'${previewId}')">×</button>
                </div>
            `;
        };
        reader.readAsDataURL(file);
    });
    updateImageCounters();
}
function removeProjectImage(type,index,previewId){
    PROJECT_IMAGES[type].splice(index,1);
    let input=null;
    if(type==="render"){input=document.getElementById("renderImages");}
    if(type==="floorplan"){input=document.getElementById("floorImages");}
    if(input){syncInputFiles(input,PROJECT_IMAGES[type]);}
    renderPreview(type,previewId);
}
function removeExistingProjectImage(type,index,imageId){
    if(!window.deletedProjectImages){
        window.deletedProjectImages = [];
    }
    window.deletedProjectImages.push(imageId);
    PROJECT_IMAGES[type].splice(index,1);
    renderPreview(type, type==="render" ? "renderPreview" : "floorPreview");
}
function updateImageCounters(){
    const renderCount=PROJECT_IMAGES.render.length;
    const floorCount=PROJECT_IMAGES.floorplan.length;
    let elevationCount=0;
    Object.keys(PROJECT_IMAGES.elevations).forEach(key=>{
        elevationCount+=PROJECT_IMAGES.elevations[key].length;
    });
    if(document.getElementById("renderImageCount"))
        document.getElementById("renderImageCount").innerText=renderCount;
    if(document.getElementById("floorImageCount"))
        document.getElementById("floorImageCount").innerText=floorCount;
    if(document.getElementById("elevationImageTotal"))
        document.getElementById("elevationImageTotal").innerText=elevationCount;
    if(document.getElementById("grandImageCount"))
        document.getElementById("grandImageCount").innerText= renderCount+floorCount+elevationCount;
}
function generateElevationImageInputs(){
    const cards=document.querySelectorAll(".elevation-card");
    const tbody=document.getElementById("projectImagesTableBody");
    tbody.querySelectorAll(".dynamicElevationRow").forEach(row=>row.remove());
    PROJECT_IMAGES.elevations={};
    cards.forEach((card,index)=>{
        const letter=String.fromCharCode(65+index);
        if(!PROJECT_IMAGES.elevations[index]){
            PROJECT_IMAGES.elevations[index]=[];
        }
        tbody.insertAdjacentHTML("beforeend",`
            <tr class="dynamicElevationRow">
                <td><strong>Elevation ${letter}</strong></td>
                <td><input type="file" id="elevationImageInput_${index}" class="form-control" multiple accept="image/*"></td>
                <td><div id="elevationPreview_${index}" class="image-preview-container"></div></td>
                <td>-</td>
            </tr>
        `);
    });
    initializeElevationInputs();
    updateImageCounters();
}
function initializeElevationInputs(){
    Object.keys(PROJECT_IMAGES.elevations).forEach(index=>{
        const input=document.getElementById("elevationImageInput_"+index);
        if(!input) return;
        input.addEventListener("change",function(){
            const files=Array.from(this.files);
            files.forEach(file=>{
                const exists=PROJECT_IMAGES.elevations[index].some(existing=>
                    existing.name===file.name &&
                    existing.size===file.size &&
                    existing.lastModified===file.lastModified
                );
                if(!exists){
                    PROJECT_IMAGES.elevations[index].push(file);
                }
            });
            syncInputFiles(input,PROJECT_IMAGES.elevations[index]);
            renderElevationPreview(index);
        });
        renderElevationPreview(index);
    });
}
function renderElevationPreview(index){
    const container = document.getElementById("elevationPreview_" + index);
    if(!container) return;
    container.innerHTML = "";
    PROJECT_IMAGES.elevations[index].forEach((file,fileIndex)=>{
        if(file.image_path){
            container.innerHTML += `
                <div class="image-preview-box">
                    <img src="/QG/uploads/${file.image_path}" class="image-thumb" onclick="openImagePreview('/QG/uploads/${file.image_path}')">
                    <button type="button" class="image-delete-btn" onclick="removeExistingElevationImage(${index},${fileIndex},${file.id})">×</button>
                </div>
            `;
            return;
        }
        const reader = new FileReader();
        reader.onload = function(e){
            container.innerHTML += `
                <div class="image-preview-box">
                    <img src="${e.target.result}" class="image-thumb" onclick="openImagePreview('${e.target.result}')">
                    <button type="button" class="image-delete-btn" onclick="removeElevationImage(${index},${fileIndex})">×</button>
                </div>
            `;
        };
        reader.readAsDataURL(file);
    });
    updateImageCounters();
}
function removeElevationImage(index,fileIndex){
    PROJECT_IMAGES.elevations[index].splice(fileIndex,1);
    syncInputFiles(
        document.getElementById("elevationImageInput_"+index),
        PROJECT_IMAGES.elevations[index]
    );
    renderElevationPreview(index);
}
function removeExistingElevationImage(index,fileIndex,imageId){
    if(!window.deletedProjectImages){
        window.deletedProjectImages = [];
    }
    window.deletedProjectImages.push(imageId);
    PROJECT_IMAGES.elevations[index].splice(fileIndex,1);
    renderElevationPreview(index);
}
function openImagePreview(src){
    const modal=document.getElementById("imagePreviewModal");
    const img=document.getElementById("imagePreviewModalImg");
    img.src=src;
    modal.style.display="flex";
}
document.addEventListener("click",function(e){
    const modal=document.getElementById("imagePreviewModal");
    if(!modal) return;
    if(
        e.target.classList.contains("image-preview-close") ||
        e.target===modal
    ){
        modal.style.display="none";
    }
});
document.addEventListener("DOMContentLoaded",()=>{
    initializeImageInput("renderImages","renderPreview","render");
    initializeImageInput("floorImages","floorPreview","floorplan");
    const enhanceBtn = document.getElementById("enhanceRenderBtn");
    if(enhanceBtn){
        enhanceBtn.addEventListener("click",enhanceRenderImages);
    }
});
async function enhanceRenderImages(event){
    event.preventDefault();
    if(PROJECT_IMAGES.render.length===0){
        alert("Please upload at least one render image.");
        return;
    }
    const button=document.getElementById("enhanceRenderBtn");
    button.disabled=true;
    button.innerHTML="Enhancing...";
    const enhanced=[];
    for(const image of PROJECT_IMAGES.render){
        if(!(image instanceof File)){
            continue;
        }
        const formData=new FormData();
        formData.append("image",image);
        try{
            const response=await fetch(
                BASE_URL+
                "image-manager/api/enhance.php",
                {
                    method:"POST",
                    body:formData
                }
            );
            const result=await response.json();
            if(result.status){
                enhanced.push(result.image);
            }
            else{
                console.error(result);
            }
        }
        catch(error){
            console.error(error);
        }
    }
    button.disabled=false;
    button.innerHTML="Enhance";
    console.log(enhanced);
    alert("Enhancement completed.");
}