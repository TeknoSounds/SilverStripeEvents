<?php

    function create_new_vb_thread($threadid, $date, $name, $venue, $city, $state, $description) {
        $postip = "";
        $userid = 243;
        $title = ($date . ' - ' . $name . ' @ ' . $venue . ' - ' . $city . ', ' . $state);
        $threadinfo = array();
        $forumdir = "";
        $specialtemplates = array();
        $actiontemplates = array();
        $globaltemplates = array();
        global $vbulletin;

        chdir($forumdir);

        require($forumdir . '/global.php');
        require($forumdir . '/includes/functions_databuild.php');

        define('VB_AREA', 'External'); 
        define('SKIP_SESSIONCREATE', 1); 
        define('SKIP_USERINFO', 1); 
        
        //Determine City/Forum
        if ($state == "TX") {
            switch ($city) {
                case "Austin":
                    $forumid = 70;
                    break;
                case "Dallas":
                    $forumid = 77;
                    break;
                case "Houston":
                    $forumid = 78;
                    break;
                case "San Antonio":
                    $forumid = 79;
                    break;
                default:
                    $forumid = 80;
                    break;
            }
        }
        else {
            $forumid = 81;
        }

        //Create new thread given info below
        $threaddm =& datamanager_init('Thread_FirstPost', $vbulletin, ERRTYPE_ARRAY, 'threadpost');

        // Find user information
        if (!$userinfo = fetch_userinfo($userid))
        {
            die("Invalid User!");
        }

        $foruminfo = fetch_foruminfo($forumid);
        
        $threaddm->set_info('thread', $threadinfo);
        $threaddm->set_info('user',$userinfo);
        $threaddm->set('userid',$userinfo['userid']);
        $threaddm->setr('forumid', $forumid);
        $threaddm->setr('title', $title);
        $threaddm->set('pagetext', $description);
        $threaddm->set('allowsmilie', 1);
        $threaddm->set('visible', 1);
        $threaddm->set('ipaddress', $postip);
        $threaddm->set('dateline', TIMENOW);
        
        if ($threadid != -1) {
            $existing = array( 
                'userid' => $userid, 
                'threadid' => $threadid
            );  
            $threaddm->set_existing($existing);  
        }
        $threaddm->set_info('forum', $foruminfo);
                
        $threaddm->pre_save();
        if(count($threaddm->errors) < 1)
        {
            $threadid = $threaddm->save();
            unset($threaddm);
            build_thread_counters($threadid);
            echo $threadid;
        }
        else 
        {
            print "Error making new thread! " . $threaddm->errors[0] . $threaddm->errors[1] . $threaddm->errors[2] ;
        }
        
        build_forum_counters($forumid);

    }

    $threadid = $_POST['threadid'];
    $date = $_POST['date'];
    $name = $_POST['name'];
    $venue = $_POST['venue'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $description = $_POST['description'];

    if ($_POST['secret_key'] == ''){
        create_new_vb_thread($threadid, $date, $name, $venue, $city, $state, $description); 
    }
?>
