<tr class="loftRow">
    <td class="srNo"></td>
    <td class="description"></td>
    <td><input type="number" class="modern-input widthMM" oninput="calculateUnitSqft(this)" min="0"></td>
    <td><input type="number" class="modern-input heightMM" oninput="calculateUnitSqft(this)" min="0"></td>
    <td><input type="number" class="modern-input depthMM" min="0" max="600" oninput="if(this.value > 600) this.value = 600; if(this.value < 0) this.value = 0;"></td>
    <td><input type="text" class="modern-input sqft" readonly></td>
    <td class="carcassCategoryCell"></td>
    <td>
        <select class="modern-input carcassMaterial" onchange="calculateCarcassAmount(this)">
            <option value="">Select Material</option>
        </select>
    </td>
    <td><input type="text" class="modern-input carcassTotal" readonly></td>
    <td class="shutterCategoryCell"></td>
    <td>
        <select class="modern-input shutterSubMaterial" onchange="calculateShutterAmount(this)">
            <option value="">Select Material</option>
        </select>
    </td>
    <td><input type="text" class="modern-input shutterTotal" readonly></td>
</tr>