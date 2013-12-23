$(document).ready(function(){
	$window = $(window);
	$('[data-type]').each(function() {	
		$(this).data('offsetY', parseInt($(this).attr('data-offsetY')));
		$(this).data('Xposition', $(this).attr('data-Xposition'));
		$(this).data('speed', $(this).attr('data-speed'));
	});

	$('section[data-type="background"]').each(function(){

		var $self = $(this),
			offsetCoords = $self.offset(),
			topOffset = offsetCoords.top;

	    $(window).scroll(function() {

			if ( ($window.scrollTop() + $window.height()) > (topOffset) &&
				 ( (topOffset + $self.height()) > $window.scrollTop() ) ) {
							
				var yPos = -($window.scrollTop() / $self.data('speed')); 

				if ($self.data('offsetY')) {
					yPos += $self.data('offsetY');
				}
				
				var coords = '50% '+ yPos + 'px';

				$self.css({ backgroundPosition: coords });

				$('[data-type="sprite"]', $self).each(function() {

					var $sprite = $(this);
					
					var yPos = -($window.scrollTop() / $sprite.data('speed'));					
					var coords = $sprite.data('Xposition') + ' ' + (yPos + $sprite.data('offsetY')) + 'px';
					
					$sprite.css({ backgroundPosition: coords });													
					
				});

				$('[data-type="video"]', $self).each(function() {
					
					var $video = $(this);

					var yPos = -($window.scrollTop() / $video.data('speed'));					
					var coords = (yPos + $video.data('offsetY')) + 'px';
	
					$video.css({ top: coords });													
					
				});
			
			};
	
		});
			
	});	

}); 
