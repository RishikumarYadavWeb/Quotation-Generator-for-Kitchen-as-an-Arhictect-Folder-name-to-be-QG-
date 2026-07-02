<?php
    include '../db.php';
    include '../includes/header.php';
    include '../includes/sidebar.php';
    if(!can('permissions_manage')){
        die('Access Denied');
    }
?>
<style>
.page-content{padding:30px;width:100%}.permission-form-card{width:100%;max-width:650px;background:#ffffff;padding:35px;border-radius:18px;box-shadow:0 4px 20px rgba(0,0,0,0.06)}.permission-form-card h2{margin:0 0 25px 0;font-size:28px;font-weight:700;color:#111827}.permission-form-card input{width:100%;height:52px;border:1px solid #d1d5db;border-radius:12px;padding:0 16px;font-size:14px;color:#111827;transition:0.3s ease;background:#fff}.permission-form-card input:focus{outline:none;border-color:#111827;box-shadow:0 0 0 4px rgba(17,24,39,0.08)}.permission-form-card button{background:#111827;color:#fff;border:none;padding:14px 22px;border-radius:12px;font-size:14px;font-weight:600;cursor:pointer;transition:0.3s ease}.permission-form-card button:hover{transform:translateY(-2px);opacity:0.92}
@media(max-width:768px){.page-content{padding:20px}.permission-form-card{padding:22px}}
</style>
<div class="page-card">
    <div class="permission-form-card">
        <form action="save.php" method="POST">
            <h2>Create Permission</h2>
            <input type="text" name="module" placeholder="Module Name" required>
            <br><br>
            <input type="text" name="permission_name" placeholder="Permission Name" required>
            <br><br>
            <button type="submit">Save Permission</button>
        </form>
    </div>
</div>
<?php include '../includes/footer.php'; ?>