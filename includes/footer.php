            </div>
        </main>
        <div class="modal fade" id="imagePreviewModal" tabindex="-1">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Elevation Image Preview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img id="largePreviewImage" src="" class="img-fluid rounded" style="max-height:80vh;">
                    </div>
                </div>
            </div>
        </div>
        <script>
        function loadDrawerEditData(){
            console.log('STEP 1');
            if(
                typeof EDIT_DRAWERS === 'undefined'
            ){
                console.log('EDIT_DRAWERS undefined');
                return;
            }
            console.log('STEP 2');
            if(
                EDIT_DRAWERS.length === 0
            ){
                console.log('No drawers found');
                return;
            }
            console.log('STEP 3');
            EDIT_DRAWERS.forEach(
                function(drawer,index){
                    console.log('DRAWER INDEX:',index);
                    console.log(drawer);
                }
            );
            console.log('STEP 4');
        }
        </script>
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="/QG/assets/js/script.js"></script>
        <script src="/QG/assets/js/elevation.js"></script>
        <script src="/QG/assets/js/unit.js"></script>
        <script src="/QG/assets/js/drawer.js"></script>
        <script src="/QG/assets/js/shelf.js"></script>
        <script src="/QG/assets/js/save.js"></script>
        <script src="/QG/assets/js/update.js"></script>
        <?php 
            $months = $months ?? [];
            $revenues = $revenues ?? [];
            $projectLabels = $projectLabels ?? [];
            $projectCounts = $projectCounts ?? [];
            $projectSqfts = $projectSqfts ?? [];
        ?>
        <script>
            document.addEventListener(
                'click',
                function(e){
                    if(
                        e.target.classList.contains('remove-old-image')
                    ){
                        const image = e.target.dataset.image;
                        Object.keys(
                            window.oldElevationImages
                        ).forEach(key => {
                            window.oldElevationImages[key] =
                                window.oldElevationImages[key]
                                .filter(img => img !== image);
                            if(
                                window.oldElevationImages[key].length === 0
                            ){
                                delete window.oldElevationImages[key];
                            }
                        });
                        if(
                            !window.deletedImages.includes(image)
                        ){
                            window.deletedImages.push(image);
                        }
                        console.log('UPDATED OLD IMAGES:',window.oldElevationImages);
                        e.target
                            .closest('.position-relative')
                            .remove();
                    }
                }
            );
            const revenueChart=document.getElementById('revenueChart');if(revenueChart){new Chart(revenueChart,{type:'line',data:{labels:<?=json_encode($months);?>,datasets:[{label:'Revenue',data:<?=json_encode($revenues);?>,borderColor:'#2563eb',backgroundColor:'rgba(37,99,235,0.15)',fill:!0,tension:0.4,borderWidth:4,pointRadius:5}]},options:{responsive:!0,plugins:{legend:{display:!1}}}})}
            const projectChart=document.getElementById('projectChart');if(projectChart){new Chart(projectChart,{type:'doughnut',data:{labels:<?=json_encode($projectLabels);?>,datasets:[{data:<?=json_encode($projectCounts);?>,backgroundColor:['#2563eb','#10b981','#8b5cf6','#f59e0b','#ef4444'],borderWidth:0}]},options:{responsive:!0,cutout:'70%',plugins:{legend:{position:'bottom'}}}})}
            const sqftChart=document.getElementById('sqftChart');if(sqftChart){new Chart(sqftChart,{type:'bar',data:{labels:<?=json_encode($projectLabels);?>,datasets:[{label:'Sq.Ft',data:<?=json_encode($projectSqfts);?>,backgroundColor:['#2563eb','#10b981','#8b5cf6','#f59e0b','#ef4444'],borderRadius:12}]},options:{responsive:!0,plugins:{legend:{display:!1}}}})}
            const clientDropdown=$('#client_id');if(clientDropdown.length){clientDropdown.on('change',function(){let client_id=$(this).val();if(!client_id){return}
            $.ajax({url:'/QG/ajax/get-client.php',type:'POST',dataType:'json',data:{client_id:client_id},success:function(response){if(!response.status){return}
            const data=response.data;$('#phone').val(data.phone||'');$('#email').val(data.email||'');$('#gst_number').val(data.gst_number||'');$('#pan_number').val(data.pan_number||'');$('#address').val(data.address||'');$('#shippingAddress').val(data.shipping_address||'')}})})}
        </script>
    </body>
</html>