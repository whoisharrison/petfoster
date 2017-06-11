<main class="bg">
	<div class="container">
		<div class="row">

			<div class="col-md-4">
				<h1>Create New Message</h1>

				<!-- Create New Message Form -->
				<form id="messageForm" name="messageForm" #messageForm ="ngForm" (submit)="createMessage();">
					<div class="form-group">
						<label class="sr-only" for="messageTitle">Title <span class="text-danger">*</span></label>
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-pencil" aria-hidden="true"></i>
							</div>
							<input type="text" class="form-control" id="messageTitle" name="messageTitle" placeholder="Message Subject" [(ngModel)]="newMessage.messageTitle">
						</div>
					</div>
					<div class="form-group">
						<label class="sr-only" for="messageContent">Content <span class="text-danger">*</span></label>
						<div class="input-group">
							<div class="input-group-addon">
								<i class="fa fa-envelope" aria-hidden="true"></i>
							</div>
							<textarea class="form-control" name="messageContent" id="messageContent" cols="30" rows="10" placeholder="1024 characters max."></textarea>
						</div>
					</div>

					<button class="btn btn-success" type="submit"><i class="fa fa-paper-plane"></i> Submit</button>
					<button class="btn btn-warning" type="reset"><i class="fa fa-ban"></i> Reset</button>
				</form>

				<!--				what the deuce is this??-->
				<div *ngIf="status !== null" class="alert alert-dismissible" [ngClass]="status.type" role="alert">
					<button type="button" class="close" aria-label="Close" (click)="status = null;"><span aria-hidden="true">&times;</span></button>
					{{ status.message }}
				</div>

			</div>

			<div class="col-md-8">
				<h1>Message History</h1>

				<!-- Begin Message Item -->
				<div *ngFor="let message of messages" class="panel panel-default">

					<div class="panel-heading">
						<div class="h4">{{ message.messageTitle }} <small>{{ message.messageDate | date:"medium" }}</small></div>
					</div>
					<div class="panel-body">
						{{ message.messageContent }}
					</div>
				</div>
			</div>
		</div>
	</div>
</main>