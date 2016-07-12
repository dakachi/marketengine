<?php get_sidebar('listing');?>
<div class="me-col-md-3">
	<div class="me-content-sidebar">
		<form id="me-filter-form" action="">
			<div class="me-sidebar-shop me-sidebar-categories">
				<div class="me-title-sidebar">
					<p>CATEGORIES</p>
				</div>
				<ul class="me-menu-categories">
					<li><a href="#">All</a></li>
					<li class="active">
						<a href="#">Advertive</a>
						<ul class="me-child-categories">
							<li><a href="#">Electrial</a></li>
							<li><a href="#">Electric</a></li>
						</ul>
					</li>
					<li><a href="">Telecommunications</a></li>
					<li><a href="">Auto & Transportation</a></li>
				</ul>
			</div>
			<div class="me-sidebar-shop me-sidebar-listingtype">
				<div class="me-title-sidebar">
					<p>LISTING TYPES</p>
				</div>
				<div class="me-listingtype-filter">
					<label><input type="checkbox" name="">Offering</label>
				</div>
				<div class="me-listingtype-filter">
					<label><input type="checkbox" name="">Selling</label>
				</div>
				<div class="me-listingtype-filter">
					<label><input type="checkbox" name="">Renting Out</label>
				</div>
			</div>
			<div class="me-sidebar-shop me-sidebar-price">
				<div class="me-title-sidebar">
					<p>PRICE</p>
				</div>
				<div class="me-price-filter">
					<div id="me-range-price" min="1" max="500" step="1"></div>
					<div class="me-row">
						<div class="me-col-xs-5"><input class="me-range-price me-range-min" type="number" name="price-min" value=""></div>
						<div class="me-col-xs-2 "><span class="me-range-dash">-</span></div>
						<div class="me-col-xs-5"><input class="me-range-price me-range-max" type="number" name="price-min" value=""></div>
					</div>
				</div>
			</div>
			<div class="me-sidebar-button">
				<input class="me-filter-btn" type="submit" value="Filter">
				<!-- <input class="" type="button" value="Default"> -->
			</div>
		</form>
	</div>
</div>
