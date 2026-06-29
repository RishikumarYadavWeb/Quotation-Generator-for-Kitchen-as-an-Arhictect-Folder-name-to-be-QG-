<tr class="bottomRow">
    <td class="srNo"></td>
    <td class="description"></td>
    <td><input type="number" class="modern-input widthMM" oninput="calculateUnitSqft(this)" min="0"></td>
    <td><input type="number" class="modern-input heightMM" oninput="calculateUnitSqft(this)" min="0"></td>
    <td><input type="number" class="modern-input depthMM" value="600" min="0"></td>
    <td><input type="text" class="modern-input sqft" readonly min="0"></td>
    <td class="carcassCategoryCell"></td>
    <td>
        <select class="modern-input carcassMaterial" onchange="calculateCarcassAmount(this)">
            <option value="">Select Material</option>
        </select>
    </td>
    <td><input type="text" class="modern-input carcassTotal" readonly></td>
    <td>
        <select class="modern-input frontType" onchange="toggleFrontType(this)">
            <option value="">Select Type</option>
            <option value="shutter">Shutter</option>
            <option value="drawer">Drawer</option>
        </select>
    </td>
    <td class="shutterCategoryCell"></td>
    <td>
        <select class="modern-input shutterSubMaterial" onchange="calculateShutterAmount(this)">
            <option value="">Select Material</option>
        </select>
    </td>
    <td><input type="text" class="modern-input shutterTotal" readonly></td>
</tr>