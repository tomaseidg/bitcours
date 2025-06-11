<!-- Js -->
    <script src="../assets/js/jquery.min.js"></script>
    <!-- Boostrap Js  -->
    <script src="../assets/js/popper.min.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <!-- MeanMenu JS -->
    <script src="../assets/js/jquery.meanmenu.js"></script>
    <script src="../assets/js/jquery.magnific-popup.min.js"></script>
    <!-- Owl carasol Js -->
    <script src="../assets/js/owl.carousel.min.js"></script>
    <!-- Wow js -->
    <script src="../assets/js/wow.min.js"></script>
    <!-- Isotope Js -->
    <script src="../assets/js/isotope.pkgd.min.js"></script>
    <!-- Form Validator Js  -->
    <script src="../assets/js/form-validator.min.js"></script>

    <script>
/*==============================================================*/
// Raque Contact Form  JS
/*==============================================================*/
(function ($) {
    "use strict"; // Start of use strict
    $("#contactForm").validator().on("submit", function (event) {
        if (event.isDefaultPrevented()) {
            // handle the invalid form...
            formError();
            submitMSG(false, "Did you fill in the form properly?");
        } else {
            // everything looks good!
            event.preventDefault();
            submitForm();
        }
    });


    function submitForm(){
        // Initiate Variables With Form Content
        var name = $("#name").val();
        var email = $("#email").val();
        var msg_subject = $("#msg_subject").val();
        var phone_number = $("#phone_number").val();
        var message = $("#message").val();


        $.ajax({
            type: "POST",
            url: "../assets/php/form-process.php",
            data: "name=" + name + "&email=" + email + "&msg_subject=" + msg_subject + "&phone_number=" + phone_number + "&message=" + message,
            success : function(text){
                if (text == "success"){
                    formSuccess();
                } else {
                    formError();
                    submitMSG(false,text);
                }
            }
        });
    }

    function formSuccess(){
        $("#contactForm")[0].reset();
        submitMSG(true, "Message Submitted!")
    }

    function formError(){
        $("#contactForm").removeClass().addClass('shake animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
            $(this).removeClass();
        });
    }

    function submitMSG(valid, msg){
        if(valid){
            var msgClasses = "h4 tada animated text-success";
        } else {
            var msgClasses = "h4 text-danger";
        }
        $("#msgSubmit").removeClass().addClass(msgClasses).text(msg);
    }
}(jQuery)); // End of use strict
	</script>

    <!-- Main js -->
    <script src="../assets/js/main.js"></script>