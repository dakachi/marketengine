<?php
$payment_date = date_i18n( get_option( 'date_format' ), strtotime( $transaction->post_date ) );
$order_number = '#' . $transaction->get_order_number();
?>
<div class="marketengine-content">
	<div class="me-order-detail">
		<div class="me-order-detail-block">
			<div class="me-row">
				<div class="me-col-md-7">
					<div class="me-row">
						<div class="me-col-md-6 me-col-xs-6">
							<div class="me-orderid-info">
								<h5><?php echo __( 'Transaction ID:', 'enginethemes' ); ?></h5>
								<p><?php echo $order_number; ?></p>
							</div>
						</div>
						<div class="me-col-md-6 me-col-xs-6">
							<div class="me-orderdate-info">
								<h5><?php echo __('Date of purchase:', 'enginethemes'); ?></h5>
								<p class="me-orderdate-info"><?php echo $payment_date; ?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="me-order-detail-block">
			<div class="me-orderstatus-info">
				<h5><?php echo __('Order status:', 'enginethemes'); ?></h5>
				<div class="me-orderstatus">
					<!-- <span class="me-order-complete">Complete</span>
					<span class="me-order-pending">Pending</span>
					<span class="me-order-close">Close</span>
					<span class="me-order-resolve">Resolve</span> -->
					<span class="me-order-dispute">Dispute</span>
					<p class=""><i class="icon-me-status-info"></i>This order has been disputed by buyer. Resolve it as soon as possible.</p>
				</div>
				<div class="me-line-process-order">
					<div class="me-line-step-order active">
						<span>Check payment</span>
					</div>
					<div class="me-line-step-order active">
						<span>Active order</span>
					</div>
					<div class="me-line-step-order current">
						<span>Mark completed</span>
					</div>
					<div class="me-line-step-order">
						<span>Closed order</span>
					</div>
				</div>
			</div>

		</div>

		<div class="me-order-detail-block">
			<div class="me-orderitem-info">
				<h5><?php echo __('Order item', 'enginethemes'); ?></h5>
				<div class="me-table me-cart-table">
					<div class="me-table-rhead">
						<div class="me-table-col me-cart-name"><?php echo __('Listing', 'enginethemes'); ?></div>
						<div class="me-table-col me-cart-price"><?php echo __('Price', 'enginethemes'); ?></div>
						<div class="me-table-col me-cart-units"><?php echo __('Units', 'enginethemes'); ?></div>
						<div class="me-table-col me-cart-units-total"><?php echo __('Total', 'enginethemes'); ?></div>
					</div>
					<div class="me-table-row me-cart-item">
						<div class="me-table-col me-cart-name">
							<div class="me-cart-listing">
								<a href="#">
									<img src="../assets/img/2.jpg" alt="">
									<span>Lorem Ipsum is simply dummy text Lorem Ipsum is simply</span>
								</a>
							</div>
						</div>
						<div class="me-table-col me-cart-price"><span>Price</span>$20</div>
						<div class="me-table-col me-cart-units"><span>Units</span><input type="number" value="20"></div>
						<div class="me-table-col me-cart-units-total">$400</div>
					</div>
					<div class="me-table-row me-cart-item">
						<div class="me-table-col me-cart-name">
							<div class="me-cart-listing">
								<a href="#">
									<img src="../assets/img/2.jpg" alt="">
									<span>Lorem Ipsum is simply dummy text Lorem Ipsum is simply</span>
								</a>
							</div>
						</div>
						<div class="me-table-col me-cart-price"><span>Price</span>$12</div>
						<div class="me-table-col me-cart-units"><span>Units</span><input type="number" value="60"></div>
						<div class="me-table-col me-cart-units-total">$720</div>
					</div>
					<div class="me-table-row me-cart-rshippingfee">
						<div class="me-table-col me-table-empty"></div>
						<div class="me-table-col me-table-empty"></div>
						<div class="me-table-col me-cart-shippingfee"><?php echo __('Shipping fee:', 'enginethemes'); ?></div>
						<div class="me-table-col me-cart-shippingfee-price">$100</div>
					</div>
					<div class="me-table-row me-cart-rtotals">
						<div class="me-table-col me-table-empty"></div>
						<div class="me-table-col me-table-empty"></div>
						<div class="me-table-col me-cart-amount"><?php echo __('Total amount:', 'enginethemes'); ?></div>
						<div class="me-table-col me-cart-totals">$1220</div>
					</div>
				</div>
				<div class="me-order-submit">
					<input class="me-order-submit-btn" type="submit" value="MARK COMPLETED">
				</div>
			</div>


		</div>

		<div class="me-order-detail-block">
			<div class="me-row">
				<div class="me-col-md-7">
					<div class="me-row">
						<div class="me-col-md-6 me-col-sm-6">
							<div class="me-orderbill-info">
								<h5><?php echo __( 'Billed to:', 'enginethemes' ); ?></h5>
								<p>Sean Connery 1017 Lac Long Quan ,CMC, Vietnam</p>
							</div>
						</div>
						<div class="me-col-md-6 me-col-sm-6">
							<div class="me-ordership-info">
								<h5><?php echo __( 'Shipped to:', 'enginethemes' ); ?></h5>
								<p>Sean Connery 1017 Lac Long Quan ,CMC, Vietnam</p>
							</div>
						</div>
					</div>
				</div>
				<div class="me-col-md-5">
					<div class="me-ordernotes-info">
						<h5><?php echo __( 'Order Notes:', 'enginethemes' ); ?></h5>
						<p class="">Curabitur Curabitur dictum laoreet lectus vel tempus. Ut ultricies lorem augue, ac gravida di Curabitur dictum laoreet lectus vel tempus. Ut ultricies lorem augue, ac gravida diam bibendum et. Proin ligula urna, feugiat u Curabitur dictum laoreet lectus vel tempus. Ut ultricies lorem augue, ac gravida diam bibendum et. Proin ligula urna, feugiat u am bibendum et. Proin ligula urna, feugiat u dictum laoreet lectus vel tempus. Ut ultricies lorem augue, ac gravida diam bibendum et. Proin ligula urna, feugiat ut risus ac,  Duis maximus quam ut justo accumsan, in luctus lacus semper. Suspendisse facilisis hendrerit ante, a congue lacus cursus vitae. Nunc iaculis lacinia dolor, sed congue nibh.</p>
					</div>
				</div>
			</div>
		</div>

	</div>
	<div class="me-row">
		<div class="me-col-md-9">
			<div class="me-orderlisting-info">
				<a class="me-orderlisting-thumbs" href=""><img src="../assets/img/2.jpg" alt=""></a>
				<div class="me-listing-info">
					<h2><a href="">Extra Slim Innovator Wool Blend Navy Suit Jacket</a></h2>
					<div class="me-rating">
						<i class="icon-me-star"></i>
						<i class="icon-me-star"></i>
						<i class="icon-me-star"></i>
						<i class="icon-me-star"></i>
						<i class="icon-me-star-o"></i>
					</div>
					<div class="me-count-purchases-review">
						<span>12 Purchase</span><span>30 review</span>
					</div>
					<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque id ligula quis ligula placerat mattis. Aenean a eros non est vehicula egestas sit amet sit amet libero. Etiam ac </p>
					<a class="me-listing-info-view" href="#">view detail</a>
				</div>
				<a class="me-orderlisting-review" href="">RATE &amp; REVIEW NOW</a>
			</div>

			<div class="me-authors me-authors-xs me-visible-sm me-visible-xs">
				<span class="me-avatar">
					<img src="http://0.gravatar.com/avatar/c655f931959fd28e3594563edd348833?s=60&d=mm&r=G" alt="">
					<b>author listing</b>
				</span>
				<ul class="me-author-info">
					<li>
						<span class="pull-left"><?php echo __( 'From:', 'enginethemes' ); ?></span>
						<b class="pull-right">Banglades</b>
					</li>
					<li>
						<span class="pull-left"><?php echo __( 'Language:', 'enginethemes' ); ?></span>
						<b class="pull-right">Vietnam</b>
					</li>
					<li>
						<span class="pull-left"><?php echo __( 'Member Sinced:', 'enginethemes' ); ?></span>
						<b class="pull-right">30 NOV, 2017</b>
					</li>
				</ul>
				<a href="" class="me-view-profile"><?php echo __( 'View profile', 'enginethemes' ); ?></a>
			</div>


			<div class="me-transaction-dispute">
				<p><?php echo __('In the case you find out something unexpected. Please tell us your problems.', 'enginethemes'); ?></p>
				<a href="#" class="">DISPUTE</a>
			</div>

		</div>
		<div class="me-col-md-3 me-hidden-sm me-hidden-xs">
			<div class="me-authors">
				<span class="me-avatar">
					<img src="http://0.gravatar.com/avatar/c655f931959fd28e3594563edd348833?s=60&d=mm&r=G" alt="">
					<b>author listing</b>
				</span>
				<ul class="me-author-info">
					<li>
						<span class="pull-left">From:</span>
						<b class="pull-right">Banglades</b>
					</li>
					<li>
						<span class="pull-left">Language:</span>
						<b class="pull-right">Vietnam</b>
					</li>
					<li>
						<span class="pull-left">Member Sinced:</span>
						<b class="pull-right">30 NOV, 2017</b>
					</li>
				</ul>
				<a href="" class="me-view-profile">View profile</a>
			</div>
		</div>
	</div>
	<div class="marketengine-related-wrap">
		<h2>You may like these listings</h2>
		<div class="me-related-slider flexslider">
			<ul class="me-related slides">
				<li class="me-item-post">
					<div class="me-item-wrap">
						<a href="#" class="me-item-img">
							<img src="../assets/img/1.jpg" alt="">
							<span>VIEW DETAILS</span>
						</a>
						<div class="me-item-content">
							<h2><a href="#">Dark Gray End-On-End Innovator Suit Pant this is listing title post on site</a></h2>
							<div class="me-item-price">
								<span class="me-price pull-left">Contact</span>
							</div>
							<div class="me-item-author">
								<a href="#"><i>by</i>Username</a>
							</div>
							<div class="me-buy-now">
								<a class="me-buy-now-btn" href="#">CONTACT</a>
							</div>
						</div>
					</div>
				</li>
				<li class="me-item-post">
					<div class="me-item-wrap">
						<a href="#" class="me-item-img">
							<img src="../assets/img/1.jpg" alt="">
							<span>VIEW DETAILS</span>
						</a>
						<div class="me-item-content">
							<h2><a href="#">This is listing title post on site</a></h2>
							<div class="me-item-price">
								<span class="me-price pull-left"><b>$105</b></span>
								<div class="me-rating pull-right">
									<i class="icon-me-star-full"></i>
									<i class="icon-me-star-full"></i>
									<i class="icon-me-star-full"></i>
									<i class="icon-me-star-full"></i>
									<i class="icon-me-star-empty"></i>
								</div>
							</div>
							<div class="me-item-author">
								<a href="#"><i>by</i>Admin</a>
							</div>
							<div class="me-buy-now">
								<a class="me-buy-now-btn" href="#">BUY NOW</a>
							</div>
						</div>
					</div>
				</li>
				<li class="me-item-post">
					<div class="me-item-wrap">
						<a href="#" class="me-item-img">
							<img src="../assets/img/1.jpg" alt="">
							<span>VIEW DETAILS</span>
						</a>
						<div class="me-item-content">
							<h2><a href="#">Dark Gray End-On-End Innovator Suit Pant this is listing title post on site</a></h2>
							<div class="me-item-price">
								<span class="me-price pull-left">Contact</span>
							</div>
							<div class="me-item-author">
								<a href="#"><i>by</i>Username</a>
							</div>
							<div class="me-buy-now">
								<a class="me-buy-now-btn" href="#">CONTACT</a>
							</div>
						</div>
					</div>
				</li>
				<li class="me-item-post">
					<div class="me-item-wrap">
						<a href="#" class="me-item-img">
							<img src="../assets/img/1.jpg" alt="">
							<span>VIEW DETAILS</span>
						</a>
						<div class="me-item-content">
							<h2><a href="#">Dark Gray End-On-End Innovator Suit Pant this is listing title post on site</a></h2>
							<div class="me-item-price">
								<span class="me-price pull-left">$213</span>
								<div class="me-rating pull-right">
									<i class="icon-me-star-full"></i>
									<i class="icon-me-star-full"></i>
									<i class="icon-me-star-full"></i>
									<i class="icon-me-star-full"></i>
									<i class="icon-me-star-empty"></i>
								</div>
							</div>
							<div class="me-item-author">
								<a href="#"><i>by</i>Username</a>
							</div>
							<div class="me-buy-now">
								<a class="me-buy-now-btn" href="#">BUY NOW</a>
							</div>
						</div>
					</div>
				</li>
				<li class="me-item-post">
					<div class="me-item-wrap">
						<a href="#" class="me-item-img">
							<img src="../assets/img/1.jpg" alt="">
							<span>VIEW DETAILS</span>
						</a>
						<div class="me-item-content">
							<h2><a href="#">Dark Gray End-On-End Innovator Suit Pant this is listing title post on site</a></h2>
							<div class="me-item-price">
								<span class="me-price pull-left">$112</span>
								<div class="me-rating pull-right">
									<i class="icon-me-star-full"></i>
									<i class="icon-me-star-full"></i>
									<i class="icon-me-star-full"></i>
									<i class="icon-me-star-full"></i>
									<i class="icon-me-star-empty"></i>
								</div>
							</div>
							<div class="me-item-author">
								<a href="#"><i>by</i>Username</a>
							</div>
							<div class="me-buy-now">
								<a class="me-buy-now-btn" href="#">BUY NOW</a>
							</div>
						</div>
					</div>
				</li>
			</ul>
		</div>
	</div>
</div>
<!--// marketengine-content -->