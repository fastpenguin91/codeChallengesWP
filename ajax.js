function submit_me(user_id, challenge_id){
    var formStr = "<span id='challengeIsSolved' style='display: inline-block; margin: 20px; padding: 20px; background: lightgreen; border-radius: 10px;' id='solveChallenge'>Challenge is Solved!</span>";
    formStr += " <form style='display:inline-block;' id='theForm'>";
    formStr += "<input type='hidden' name='user_id' value='" + user_id + "'>";
    formStr += "<input type='hidden' name='challenge_id' value='" + challenge_id + "'>";
    formStr += "<input name='action' type='hidden' value='reset_challenge' />&nbsp;";
    formStr += "<input style='display: inline-block; margin: 20px; padding: 20px; background: lightblue; border-radius: 10px;' id='submit_button' value = 'Reset?' type='button' onClick='resetChallenge(" + user_id + "," + challenge_id + ");' /> </form>";

    jQuery.post(
        the_ajax_script.ajaxurl,
        jQuery("#theForm").serialize(),
        function(response_from_the_action_function){
            jQuery("#formArea").html(formStr);
        }
    );
}

function resetChallenge(user_id, challenge_id){
    var formStr = "<form id='theForm'>";
    formStr += "<input type='hidden' name='user_id' value='" + user_id + "'>";
    formStr += "<input type='hidden' name='challenge_id' value='" + challenge_id + "'>";
    formStr += "<input name='action' type='hidden' value='the_ajax_hook' />&nbsp;";
    formStr += "<input style='display: inline-block; margin: 20px; padding: 20px; border-radius: 10px;' id='submit_button' value = 'Solve Challenge' type='button' onClick='submit_me(" + user_id + "," + challenge_id + ");' /> </form>";
    
    jQuery.post(
        the_ajax_script.ajaxurl,
        jQuery("#theForm").serialize(),
        function(response_from_the_action_function){
            jQuery("#formArea").html(formStr);
        }
    );
}