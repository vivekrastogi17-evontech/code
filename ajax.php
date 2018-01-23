<?php
require_once( "../../../wp-load.php" );

if (isset($_POST['type']) && $_POST['type'] == 'login') {
    $response = getData($_POST['type'], '', $_POST);
    $data = json_decode($response, true);
    $txt = '';
    
    if ($data['status'] == 'success') {
        $_SESSION['CE'] = $data['data']; 
        echo json_encode(array('status' => 'success', 'message' => $data['message'],'data'=>$data['data']));
    } else {
        echo json_encode(array('status' => 'failure', 'message' => $data['message'], 'data' => $data));
    }
}

if (isset($_POST['type']) && $_POST['type'] == 'fblogin') {
    $response = getData($_POST['type'], '', $_POST);
    $data = json_decode($response, true);
    $txt = '';
    
    if ($data['status'] == 'success') {
        $_SESSION['CE'] = $data['data']; 
        echo json_encode(array('status' => 'success', 'message' => $data['message'],'data'=>$data['data']));
    } else {
        echo json_encode(array('status' => 'failure', 'message' => $data['message'], 'data' => $data));
    }
}

if (isset($_POST['type']) && $_POST['type'] == 'logout') {
    session_destroy();
    
    $_SESSION['CE'] = '';
    echo json_encode(array('status' => 'success', 'message' => 'success'));
}

if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'create_contest') {
    $data = array();
    $data = $_POST;
    $data['raffle_image'] = @$_FILES['raffle_image'];
    $response = getData($_REQUEST['type'], '', $data);  
    $data = json_decode($response, true);
    $_SESSION['ContestData'] = @$data['data'];
    echo json_encode(array('status' => 'success', 'message' => 'Congratulation!! Your contest has been created successfully'));
}

if (isset($_REQUEST['type']) && $_REQUEST['type'] == 'contest_listing') {
    $data = array();
    $data = $_POST;
    $data['raffle_image'] = $_FILES['raffle_image'];
    $response = getData($_REQUEST['type'], '', $data);  
    $data = json_decode($response, true);
    if ($data['status'] == 'success') {
        $_SESSION['CE']['Event'] = $data['data'];
        echo json_encode(array('status' => 'success', 'message' => $data['message']));
    
    } else {
        echo json_encode(array('status' => 'failure', 'message' => $data['message']));
    }
}

if (isset($_POST['type']) && $_POST['type'] == 'signup') {
    $response = getData($_POST['type'], '', $_POST);
    $data = json_decode($response, true);
    if ($data['status'] == 'success') {
        
        $_SESSION['CE'] = $data['data'];                            
        echo json_encode(array('status' => 'success', 'message' => $data['message']));
    } else {
        echo json_encode(array('status' => 'failure', 'message' => $data['message'], 'data' => $data));
    }
}

if (isset($_POST['type']) && $_POST['type'] == 'send_campaign_donation') {
    $response = getData($_POST['type'], '', $_POST);
    $data = json_decode($response, true);
    if ($data['status'] == 'success') {

        echo json_encode(array('status' => 'success', 'message' => $data['message']));
    } else {
        echo json_encode(array('status' => 'failure', 'message' => $data['message']));
    }
}

/*if (isset($_POST['type']) && $_POST['type'] == 'fblogin') {
    $response = getData($_POST['type'], '', $_POST);
    $data = json_decode($response, true);
    $txt = '';
    
    if ($data['status'] == 'success') {
        $_SESSION['CE'] = $data['data']; 
        echo json_encode(array('status' => 'success', 'message' => $data['message'],'data'=>$data['data']));
    } else {
        echo json_encode(array('status' => 'failure', 'message' => $data['message'], 'data' => $data));
    }
}*/
?>
