import {Component, OnInit} from "@angular/core";
import {PostService} from "../services/post.service";

@Component({
	selector: "result",
	templateUrl: "./templates/result.php"
})

export class ResultComponent implements OnInit {
	posts: any[] = [];
	constructor(private postService: PostService){}

	getAllPosts() : void {
		this.postService.getAllPosts()
			.subscribe(posts => {
				this.posts = posts;
			});
	}

	ngOnInit() : void {
		this.getAllPosts();
	}
}