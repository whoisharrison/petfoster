import {Component, OnInit} from "@angular/core";
import {ActivatedRoute, Params} from "@angular/router";
import {FileUploader} from "ng2-file-upload";
import {Cookie} from "ng2-cookies";

import {PostService} from "../services/post.service";
import {Post} from "../classes/post";
import {Status} from "../classes/status";

@Component({
	templateUrl: "./templates/post.php"
})

export class PostComponent implements OnInit {
	public uploader: FileUploader = new FileUploader({
		itemAlias: "dog",
		url: "./api/image/",
		headers: [
			{
				name: "X-XSRF-TOKEN",
				value: Cookie.get("XSRF-TOKEN")
			}
		],
		additionalParameter: {}
	});

	posts: Post[] = [];
	status: Status = null;

	post: Post = new Post(
		null,
		null,
		null,
		null,
		null,
		null,
		null
	);

	constructor(
		private postService: PostService,
		private route: ActivatedRoute
	) {}

	ngOnInit(): void {
		this.uploader.onSuccessItem = (
			item: any,
			response: string,
			httpStatus: number,
			headers: any
		) => {
			let reply: any;

			try {
				reply = JSON.parse(response);
			} catch(error) {
				this.status = new Status(
					500,
					"The server returned an invalid response.",
					"alert-danger"
				);

				console.error(
					"Invalid animal upload response:",
					response
				);

				return;
			}

			if(reply.status === 200) {
				this.status = new Status(
					200,
					reply.message ||
						"Animal submitted successfully.",
					"alert-success"
				);

				this.uploader.clearQueue();

				this.post = new Post(
					null,
					null,
					null,
					null,
					null,
					null,
					null
				);

				return;
			}

			this.status = new Status(
				reply.status || 500,
				reply.message ||
					"The animal could not be submitted.",
				"alert-danger"
			);
		};

		this.uploader.onErrorItem = (
			item: any,
			response: string,
			httpStatus: number,
			headers: any
		) => {
			let message =
				"The animal could not be submitted.";

			try {
				const reply = JSON.parse(response);

				if(reply.message) {
					message = reply.message;
				}
			} catch(error) {
				console.error(
					"Animal upload HTTP error:",
					httpStatus,
					response
				);
			}

			this.status = new Status(
				httpStatus || 500,
				message,
				"alert-danger"
			);
		};
	}

	getPost(): void {
		this.route.params
			.switchMap(
				(params: Params) =>
					this.postService.getPost(+params["id"])
			)
			.subscribe(
				reply => this.post = reply
			);
	}

	createPost(): void {
		this.status = null;

		if(this.uploader.queue.length === 0) {
			this.status = new Status(
				400,
				"Please select an image.",
				"alert-danger"
			);

			return;
		}

		this.uploader.options.additionalParameter = {
			postOrganizationId:
				this.post.postOrganizationId,
			postBreed:
				this.post.postBreed,
			postDescription:
				this.post.postDescription,
			postSex:
				this.post.postSex,
			postType:
				this.post.postType
		};

		this.uploader.uploadAll();
	}
}
