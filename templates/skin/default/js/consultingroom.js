/**
 * Javascript source file
 * @file        consultingroom.js
 * @description
 *
 * PHP Version  5.3
 *
 * @package     Consultingroom
 * @category
 * @copyright   2013, Vadim Pshentsov. All Rights Reserved.
 * @license     http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @author      Vadim Pshentsov <pshentsoff@gmail.com>
 * @created     16.03.13
 */

try {
    $(document).ready(function() {

        //AskForm validation
        $("#consultingroomCommunicationAskForm").validate();
        $("#consultingroomCommunicationGroupRequestForm").validate();

        //Tabs

        //When page loads...
        $(".consultingroom-data-content").hide();
        $(".consultingroom-tabs li:first").addClass("active").show();
        $(".consultingroom-data-content:first").show();

        //On Click Event
        $("ul.consultingroom-tabs li").click(function() {

            $("ul.consultingroom-tabs li").removeClass("active");
            $(this).addClass("active");
            $(".consultingroom-data-content").hide();

            var activeTab = $(this).find("a").attr("href");
            $(activeTab).fadeIn();
            return false;
        });

        $('#consultingroom-group-request-form').jqm();

        $('.js-consultingroom-group-request-form-show').click(function(){
            $('#consultingroom-group-request-form').jqmShow();
            return false;
        });

        //End Tabs

    });
} catch (e) {}