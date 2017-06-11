export class Profile {
	constructor(
		public profileId: number,
		public profileAtHandle: string,
		public profileEmail: string,
		public profileName: string,
		public profilePassword: string,
		public profilePasswordConfirm: string,
		public organizationAddress1: string,
		public organizationAddress2: string,
		public organizationCity: string,
		public organizationLicense: string,
		public organizationName: string,
		public organizationPhone: string,
		public organizationState: string,
		public organizationZip: string
	) {}
}