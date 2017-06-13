import {RouterModule, Routes} from "@angular/router";

import {HomeComponent} from "./components/home.component";
import {SignInComponent} from "./components/sign-in.component";
import {MessageComponent} from "./components/message.component";
import {PostComponent} from "./components/post.component";
import {OrganizationComponent} from "./components/organization.component";
import {FileSelectDirective} from "ng2-file-upload";
import {NavBarComponent} from "./components/navbar.component";
import {EnderComponent} from "./components/ender.component";
import {AboutComponent} from "./components/about.component";
import {ResultComponent} from "./components/result.component";
import {ProfileComponent} from "./components/profile.component";

export const allAppComponents = [
	HomeComponent,
	MessageComponent,
	SignInComponent,
	OrganizationComponent,
	PostComponent,
	FileSelectDirective,
	NavBarComponent,
	EnderComponent,
	AboutComponent,
	ResultComponent,
	ProfileComponent
];

export const routes: Routes = [
	{path: "about", component: AboutComponent},
	{path: "message",component: MessageComponent},
	{path: "organization", component: OrganizationComponent},
	{path: "post", component: PostComponent},
	{path: "profile", component: ProfileComponent},
	{path: "result", component: ResultComponent},
	{path: "signin", component: SignInComponent},
	{path: "", component: HomeComponent}
];

export const appRoutingProviders: any[] = [];

export const routing = RouterModule.forRoot(routes);