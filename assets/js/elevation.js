async function generateElevations(){
    const count = parseInt(document.getElementById('elevationCount').value) || 0;
    const container = document.getElementById('elevationContainer');
    const existingCards = container.querySelectorAll('.elevation-card');
    const existing = existingCards.length;
    if(count > existing){
        const newElevations = count - existing;
        const response = await fetch(BASE_URL + 'ajax/generate-elevation.php');
        const html = await response.text();
        const fragment = document.createDocumentFragment();
        for(let i = 0; i < newElevations; i++){
            const div = document.createElement('div');
            div.innerHTML = html;
            fragment.appendChild(
                div.firstElementChild
            );
        }
        container.appendChild(fragment);
        updateElevationNumbers();
    }
    else if(count < existing){
        for(
            let i = existing - 1;
            i >= count;
            i--
        ){
            existingCards[i].remove();
        }
        updateElevationNumbers();
        updateGrandTotal();
    }
}
function updateElevationNumbers(){
    const cards = document.querySelectorAll('.elevation-card');
    cards.forEach((card,index) => {
        const numberField = card.querySelector('.elevationNumber');
        const titleField = card.querySelector('.elevationTitle');
        if(numberField){
            numberField.innerHTML = index + 1;
        }
        if(titleField){
            titleField.innerHTML = `Elevation ${String.fromCharCode(65 + index)}`;
        }
    });
}
function updateGrandTotal(){
    let baseTotal = 0;
    document
        .querySelectorAll('.unitGrandTotal')
        .forEach(field => {
            baseTotal += getNumber(field.value);
        });
    document
        .querySelectorAll('.accessoryTotal')
        .forEach(field => {
            baseTotal += getNumber(field.value);
        });
    const packingCharge = getNumber(document.getElementById('packingCharge')?.value);
    const installationCharge = getNumber(document.getElementById('installationCharge')?.value);
    const grandTotal = baseTotal + packingCharge + installationCharge;
    const grandTotalField = document.getElementById('grandTotal');
    if(grandTotalField){
        grandTotalField.value = '₹ ' + grandTotal.toFixed(2);
    }
    calculateFinalPricing();
}
function calculateFinalPricing(){
    const grandTotal = getNumber(document.getElementById('grandTotal')?.value);
    const specialDiscount = parseFloat(document.getElementById('specialDiscount')?.value) || 0;
    const discountAmount = (grandTotal * specialDiscount) / 100;
    let finalPrice = grandTotal - discountAmount;
    finalPrice = Math.round(finalPrice);
    document.getElementById(
        'finalCustomerPrice'
    ).value = '₹ ' + finalPrice.toLocaleString('en-IN');
}
document
    .getElementById('packingCharge')
    ?.addEventListener('input',updateGrandTotal);
document
    .getElementById('installationCharge')
    ?.addEventListener('input',updateGrandTotal);
document
    .getElementById('specialDiscount')
    ?.addEventListener('input',calculateFinalPricing);
function updateTotalSqft(){
    let total = 0;
    document
    .querySelectorAll('.sqft')
    .forEach(field => {
        total += getNumber(field.value);
    });
    const totalSqftField = document.getElementById('totalSqft');
    if(totalSqftField){
        totalSqftField.value = total.toFixed(2);
    }const installationCharge = total * 400;
    const installationField = document.getElementById('installationCharge');
    if(installationField){
        installationField.value = installationCharge.toFixed(2);
    }
    updateGrandTotal();
}