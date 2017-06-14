import {Component, OnInit} from "@angular/core";
import {PostService} from "../services/post.service";
import {Post} from "../classes/post";

@Component({
	selector: "result",
	templateUrl: "./templates/result.php"
})

export class ResultComponent implements OnInit {
	posts: Post[] = [];
	constructor(private postService: PostService){}

	getAllPosts() : void {
		this.postService.getAllPosts()
			.subscribe(posts => this.posts = posts);
	}

	ngOnInit() : void {
		this.getAllPosts();
	}
}