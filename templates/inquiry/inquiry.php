<?php if($listing) : ?>
<div class="marketengine">
	<div class="me-contact-listing-wrap">
		
		<?php me_get_template('inquiry/listing-info', array('listing' => $listing)); ?>

		<div class="me-contact-listing">
			<div class="me-row">
				<div class="me-col-md-9 me-col-sm-8">
					<div class="me-contact-messages-wrap">
						<div class="me-contact-message-user">
							<h2>David Copperfield</h2>
						</div>
						<div class="me-contact-messages" style="height: 500px;">
							<ul class="me-contact-messages-list" style="overflow: hidden;overflow-y: scroll; height: 500px;">
								<?php for ($i=0; $i < 10; $i++) : ?>
									<?php me_get_template('inquiry/message-item'); ?>
								<?php endfor; ?>
							</ul>
						</div>
						<div class="me-message-typing">
							<textarea></textarea>
							<span class="me-message-send-btn"><i class="icon-me-attach"></i></span>
						</div>
					</div>
				</div>
				<div class="me-col-md-3 me-col-sm-4 ">
					<?php me_get_template('inquiry/contact-list'); ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>