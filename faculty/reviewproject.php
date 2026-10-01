<?php require_once __DIR__ . '/../contoler/db.php'; 

if (!isset($_SESSION['uid'])) {
    header("Location: ../public/login.php");
    exit();
}
if ($_SESSION['role'] != 'faculty') {
    header("Location: ../public/home.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD']=== 'POST' && (isset($_POST['txtComments']))){
    $comments = trim($_POST['txtComments']);
    $status = trim($_POST['ddiStatus']);
    $pid = trim($_POST['data-pid']);
    $rdate = date('Y-m-d H:i:s');
    if($_POST['txtComments']!== ""){
        $upreview=mysqli_query($conn,"UPDATE `tblproject` SET Comments='$comments', reviewdate='$rdate', status='$status' where pid='$pid'");
        
        if($upreview){
        $msg="Review Updated Successfully";
        Reviewmessage($msg);
        }
        else{
            $msg="Review Not Updated";
            Reviewmessage($msg);
        }
    }
    else{
        $msg="Please Enter Comments";
        Reviewmessage($msg);
    }
}
$projects=mysqli_query($conn,"select * from tblproject, tblfaculty where tblfaculty.subid=tblproject.subid");
function Reviewmessage($message){
    echo "<script>alert('$message');</script>";
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Review Projects - Faculty</title>
    <link href="../CSS/index.css" rel="stylesheet" type="text/css"/>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        .grid-container{background:white; border-radius:8px;box-shadow:0 4px 15px rgba(0,0,0,0.05);padding:20px;margin-top:20px;border:1px solid #e0e0e0;} 
        .styled-grid{width:100%;border-collapse:collapse; margin-top:10px;} 
        .styled-grid th{background:linear-gradient(to right,#1d3160,#2557d6);color:white;padding:12px; text-align:left;font-size:14px;} 
        .styled-grid td{padding:12px;border-bottom:1px solid #eaeaea; font-size:14px;color:#333;} 
        .styled-grid tr:hover{background-color:#f8f9fa;} 
        .review-card{background:#ffffff;border-radius:8px; box-shadow:0 4px 15px rgba(0,0,0,0.1);width:100%;border:1px solid #2557d6;margin-top:20px;padding:20px;box-sizing:border-box;} 
        .form-group{margin-bottom: 15px;} 
        .form-group label{display:block;font-weight:bold; margin-bottom:5px;color:#333;} 
        .form-control{width:100%; padding:10px;border:1px solid #ccc;border-radius:4px;box-sizing: border-box;} 
        .btn-submit{background-color:#2b5add;color:white; border:none; padding: 10px 20px;border-radius:4px;cursor:pointer;font-weight:bold;} 
        .btn-submit:hover{background-color:#1c45b5;}
    </style>
</head>
<body> 
<form id="form" method="post">
    <div id="Panel1" class="topbar">
        <img id="logo" class="logo" alt="Project-Gate Logo" src="../Admin/img/logo_admin.png" />
        <span style="float: right; margin:  0 0; font-size: 18px; font-weight: bold; color: green;">Faculty: <?php echo $_SESSION['username'] ?></span>
        <a id="hldash" class="nav-link" href="/Faculty/dashboard.aspx">Dashboard</a>
        <a id="hthome" class="nav-link" href="/Faculty/home.aspx">Home</a>
        <a id="hilout" class="nav-link" href="#">Log Out</a>
    </div>
    <div id="pnsidebar" class="sidebar">
        <a id="Ibtndash" href="dashboard.php">Dashboard</a>
        <a id="Ibtnpro" href="profile.php">My Profile</a>
        <a id="Ibtnproject" href="reviewproject.php" style="font-weight:bold; color:#ffeb3b;">Student Projects</a>
        <a id="Ibtnresult" href="grad.php">Student Results</a>
        <a id="Ibtnupwd" href="pwdchange.php">Password Change</a>
        <a id="Ibtlout" href="../public/logout.php">Log Out</a>
    </div>
    <div class="contant">   
        <h1>Student Projects for Review</h1>
        <span id="lblMsg" style="font-weight:bold;"></span>
        <div class="grid-container">
            <table id="gvProjects" class="styled-grid">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Title</th>
                        <th>Technology</th>
                        <th>Status</th>
                        <th>Faculty Comments</th>
                        <th>Review Date</th>
                        <th>Download</th>
                        <th>Review</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($project=mysqli_fetch_assoc($projects)){ ?>
                    <tr>
                        <td><?php echo htmlspecialchars($project['sid']); ?></td>
                        <td><?php echo htmlspecialchars($project['title']); ?></td>
                        <td><?php echo htmlspecialchars($project['technology']); ?></td>
                        <td><?php echo htmlspecialchars($project['status']); ?></td>
                        <td><?php echo htmlspecialchars($project['comments']); ?></td>
                        <td><?php echo htmlspecialchars($project['reviewdate']); ?></td>
                        <td><button type="button" style="color:#2557d6; font-weight:bold; border:none; background:none;">Download</button></td>
                        <td><button type="button"  name="btn-addreview" class="btn-addreview" style="color:Green; font-weight:bold; border:none; background:none;" data-pid="<?php echo htmlspecialchars($project['pid']); ?>">Add Review</button></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        
        <!-- Displayed dynamically based on selection -->
        <div id="pnlProject" class="review-card" style="display:none;">
            <h3 style="color:#2557d6; margin-top:0;">Submit Review for Project ID: <span id="lblSelectedPID"></span></h3>
            <input type="hidden" id="hiddenProjectID" name="data-pid" />
            <div class="form-group">
                <label>Update Status</label>
                <select id="ddiStatus" name="ddiStatus" class="form-control">
                    <option value="Accepted">Accepted</option>
                    <option value="Rejected">Rejected</option>
                    <option value="Needs Revision">Needs Revision</option>
                </select>
            </div>
            <div class="form-group">
                <label>Faculty Comments</label>
                <textarea id="txtComments" name="txtComments" class="form-control" rows="4" placeholder="Enter your feedback here..."></textarea>
            </div>
            <button type="submit" name="btnSaveReview" id="btnSaveReview" class="btn-submit">Save Review</button>
            <button type="button" id="btnCancel" class="btn-submit" style="background-color:#6c757d; margin-left: 10px;">Cancel</button>
        </div>
    </div>
</form>
<script>
$(document).ready(function(){

    $(".btn-addreview").click(function(){
        var pid = $(this).data("pid");

        $("#lblSelectedPID").text(pid);
        $("#hiddenProjectID").val(pid);

        $(".review-card").show();
    });

    $("#btnCancel").click(function(){
        $(".review-card").hide();
    });

});
</script></body>
</html>