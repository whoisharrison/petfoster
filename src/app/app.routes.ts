import {RouterModule, Routes} from "@angular/router";

import {HomeComponent} from "./components/home.component";
import {SignInComponent} from "./components/sign-in.component";
import {MessagesComponent} from "./components/messages.component";
import {PostComponent} from "./components/post.component";
import {OrganizationComponent} from "./components/organization.component";
import {FileSelectDirective} from "ng2-file-upload";
import {NavBarComponent} from "./components/navbar.component";
import {EnderComponent} from "./components/ender.component";
import {AboutComponent} from "./components/about.component";
import {ResultComponent} from "./components/result.component";

export const allAppComponents = [
	HomeComponent,
	MessagesComponent,
	SignInComponent,
	OrganizationComponent,
	PostComponent,
	FileSelectDirective,
	NavBarComponent,
	EnderComponent,
	AboutComponent,
	ResultComponent
];

export const routes: Routes = [
	{path: "organization", component: OrganizationComponent},
	{path: "signin", component: SignInComponent},
	{path: "messages",component: MessagesComponent},
	{path: "post", component: PostComponent},
	{path: "about", component: AboutComponent},
	{path: "result", component: ResultComponent},
	{path: "", component: HomeComponent}
];

export const appRoutingProviders: any[] = [];

export const routing = RouterModule.forRoot(routes);