import {RouterModule, Routes} from "@angular/router";

import {HomeComponent} from "./components/home.component";
import {SignInComponent} from "./components/sign-in.component";
import {MessagesComponent} from "./components/messages.component";
import {PostComponent} from "./components/post.component";
import {OrganizationComponent} from "./components/organization.component";
import {ImageComponent} from "./components/image.component";
import {FileSelectDirective} from "ng2-file-upload";

export const allAppComponents = [
	HomeComponent,
	MessagesComponent,
	SignInComponent,
	OrganizationComponent,
	PostComponent,
	ImageComponent,
	FileSelectDirective
];

export const routes: Routes = [
	{path: "organization", component: OrganizationComponent},
	{path: "signin", component: SignInComponent},
	{path: "messages",component: MessagesComponent},
	{path: "post", component: PostComponent},
	{path: "image", component: ImageComponent},
	{path: "", component: HomeComponent}

];

export const appRoutingProviders: any[] = [];

export const routing = RouterModule.forRoot(routes);