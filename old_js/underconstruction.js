var images = new Array('old_images/followme-over.png', 'old_images/ud-button2.png', 'old_images/send-but-on.png', 'old_images/send-but.png', 'old_images/bubble-bg.png');
var imageObjs = new Array();
for (var i in images) {
  imageObjs[i] = new Image();
  imageObjs[i].src = images[i];
}

$(document).ready(function() {
    $('#update-button').click(function() {
        var $formBubbleElement = $('#form-bubble');
        if ($formBubbleElement.is(':animated')) {
            return false;
        }
        if ($formBubbleElement.is(':visible')) {
            $formBubbleElement.fadeOut();
        } else {
            $formBubbleElement.fadeIn();
        }
    });
    
    setUpAjaxForm();
});

function setUpAjaxForm()
{
	$('#email-element').click(function() {
		if ($(this).val() == 'Email address...') {
			$(this).val('');
		}
	});
    $('#close-bubble-link').click(function() {
      $('#form-bubble').fadeOut();
    });
	$('#register-form').ajaxForm({
        target: '#form-bubble-inner',
		success: function(responseText) {
            if (responseText.search(/id="register-success"/i) != -1) {
              var $formBubbleElement = $('#form-bubble');
              setTimeout(function() { $formBubbleElement.fadeOut(); }, 3000);
            } else {
              setUpAjaxForm();
            }
            $('#close-bubble-link').click(function() {
              $('#form-bubble').fadeOut();
            });
        }
	});
}

$(window).load(function() {
    var progressBarWrap = $('#progress-bar-wrap');
    var progressAmount = $('#progress-amount');    
    var targetWidth = $('#progress-wrap').width() * (progress / 100);
    progressBarWrap.animate({
        width: targetWidth
    }, animationSpeed, null, function() {
		$('#moving-arrow').animate({height: '35'}, 'slow', 'easeOutBack', function() {
			progressAmount.text(progress + '%').fadeIn('slow');													   
		});		
    }).css('overflow', 'visible');
	$('#progress-indicator').fadeIn('slow');
});
