function submit_me(user_id, challenge_id){
    var formStr = "<span class='challengeIsSolved' id='solveChallenge'>Challenge is Solved!</span>";
    formStr += " <form style='display:inline-block;' id='theForm'>";
    formStr += "<input type='hidden' name='user_id' value='" + user_id + "'>";
    formStr += "<input type='hidden' name='challenge_id' value='" + challenge_id + "'>";
    formStr += "<input name='action' type='hidden' value='reset_challenge' />&nbsp;";
    formStr += "<input id='reset_button' value = 'Reset Challenge?' type='button' onClick='resetChallenge(" + user_id + "," + challenge_id + ");' /> </form>";

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
    formStr += "<input id='submit_button' value = 'Solve Challenge' type='button' onClick='submit_me(" + user_id + "," + challenge_id + ");' /> </form>";
    
    jQuery.post(
        the_ajax_script.ajaxurl,
        jQuery("#theForm").serialize(),
        function(response_from_the_action_function){
            jQuery("#formArea").html(formStr);
        }
    );
}