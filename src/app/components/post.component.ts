import{Component, OnInit, Input, Output} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {PostService} from "../services/post.service";
import {Post} from "../classes/post";
import {Status} from "../classes/status";

@Component({
	selector: 'post',
	templateUrl: "./templates/post-template.php"
})

export class PostComponent implements OnInit{
	posts: Post[] = [];
	status: Status = null;
	post: Post = new Post(null, null, null, null, null, null, null);
	constructor(private postService: PostService, private route: ActivatedRoute) {
	}


	ngOnInit(): void {
		this.getAlmostAllPosts();
	}

	getAlmostAllPosts() : void {
		this.postService.getPostsByPostId(2)
			.subscribe(posts=>{this.posts = posts});
	}

	getPost(): void {
		this.route.params
			.switchMap((params: Params) => this.postService.getPost(+params["id"]))
			.subscribe(reply => this.post = reply);
	}
}