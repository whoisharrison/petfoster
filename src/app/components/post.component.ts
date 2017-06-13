import{Component, OnInit, Input, Output} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {PostService} from "../services/post.service";
import {Post} from "../classes/post";
import {Status} from "../classes/status";
import {FileUploader} from "ng2-file-upload";
import {Cookie} from "ng2-cookies";
import {Observable} from "rxjs";
import "rxjs/add/observable/from";

@Component({
	selector: 'post',
	templateUrl: "./templates/post.php"
})

export class PostComponent implements OnInit{
	public uploader: FileUploader = new FileUploader({
		itemAlias: "dog",
		url: "./api/image/",
		headers: [{name: "X-XSRF-TOKEN", value: Cookie.get("XSRF-TOKEN")}],
		additionalParameter: {}
	});
	posts: Post[] = [];
	status: Status = null;
	post: Post = new Post(null, null, null, null, null, null, null);
	protected cloudinaryPublicId : string = null;
	protected cloudinaryPublicIdObservable : Observable<string> = new Observable<string>();

	constructor(private postService: PostService, private route: ActivatedRoute) {
	}


	ngOnInit(): void {
		this.uploader.onSuccessItem = (item: any, response: string, status: number, headers: any) => {
			let reply = JSON.parse(response);
			this.cloudinaryPublicId = reply.data;
			this.cloudinaryPublicIdObservable = Observable.from(this.cloudinaryPublicId);
		};
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