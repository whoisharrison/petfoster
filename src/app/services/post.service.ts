import {Injectable} from "@angular/core";
import {Http} from "@angular/http";
import {Observable} from "rxjs/Observable";
import {BaseService} from "./base.service";
import {Post} from "../classes/post";
import {Status} from "../classes/status";


import DateTimeFormat = Intl.DateTimeFormat;

@Injectable()
export class PostService extends BaseService {
	constructor(protected http: Http) {
		super(http);
	}

	private postUrl = "api/post/";

	deletePost(id: number) : Observable<Status> {
		return(this.http.delete(this.postUrl + id)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	createPost(post: Post) : Observable<any> {
		return(this.http.post(this.postUrl, post)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	editPost(post: Post) : Observable<Status> {
		return(this.http.put(this.postUrl + post.postId, post)
			.map(this.extractMessage)
			.catch(this.handleError));
	}

	getPost(id: number) : Observable<Post> {
		return(this.http.get(this.postUrl + id)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getPostsByPostId(postId: number) : Observable<Post[]> {
		return(this.http.get(this.postUrl  + postId)
			.map(this.extractData)
			.catch(this.handleError));
	}
	getPostsByPostOrganizationId(postOrganizationId: number) : Observable<Post[]> {
		return(this.http.get(this.postUrl + "?postOrganizationId=" + postOrganizationId)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getPostsByPostBreed(postBreed: string) : Observable<Post[]> {
		return(this.http.get(this.postUrl + postBreed)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getPostsByPostDescription(postDescription: string) : Observable<Post[]> {
		return(this.http.get(this.postUrl + postDescription)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getPostsByPostSex(postSex: string) : Observable<Post[]> {
		return(this.http.get(this.postUrl + postSex)
			.map(this.extractData)
			.catch(this.handleError));
	}

	getAllPosts() : Observable<Post[]> {
		return(this.http.get(this.postUrl)
			.map(this.extractData)
			.catch(this.handleError));
	}

}
