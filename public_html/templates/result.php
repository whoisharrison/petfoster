<main class="bg">
	<div class="container">
		<div class="row">
			<div class="col-xs-12">
				<h2>Results</h2>
			</div>
		</div>

		<!-- BEGIN POST ITEM -->
		<article class="search-result row" *ngFor="let post of posts">

			<div class="col-xs-12 col-sm-12 col-md-3">
				<a href="#" title="Pet Photo" class="thumbnail"><img [src]="post.imageUrl" alt="Lorem ipsum" /></a>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-2">
				<ul class="meta-search">
					<li><i class="fa fa-id-card fa-lg" aria-hidden="true"></i> <span>{{ post.postBreed }}</span></li>
					<li><i class="fa fa-venus-mars fa-lg" aria-hidden="true"></i> <span>{{ post.postSex }}</span></li>
					<li><i class="fa fa-paw fa-lg" aria-hidden="true"></i> <span>{{ post.postType }}</span></li>
				</ul>
			</div>

			<div class="col-xs-12 col-sm-12 col-md-7 excerpt">
				<h3><a href="#" title="">Available Pet</a></h3>
				<p>{{ post.postDescription }}</p>
				<div>
					<a routerLink="/message" class="btn btn-info"><i class="fa fa-envelope"></i></a>
				</div>
			</div>
			<span class="clearfix borda"></span>
		</article>

	</div><!--/.container-->
</main>