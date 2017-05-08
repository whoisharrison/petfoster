<?php

namespace Edu\Cnm\Petfoster;

require_once("autoload.php");


/**
 * Organization Class for PetRescueABQ
 *
 *
 *
 * @author Jeffrey Cooper <jcooper37@cnm.edu>
 * @version 0.1.0
 **/

	/**Class Organization
	 *@package Edu\Cnm\Petfoster
	 **/
class Organization implements \JsonSerializable {
	/**
	 *id for this Organization; this is the primary key
	 * @var int $organizationId
	 **/
	private $organizationId;
	/*
	 * id of the Profile that administers the Organization; this is a foreign key.
	 * @var int $organizationProfileId
	 **/
	private $organizationProfileId;
	/*
	 * Activation Token to authorize use of the organization profile.
	 * @var char $organizationActivationToken
	 **/
	private $organizationActivationToken;
	/*
	 * Primary address line of the organization profile.
	 * @var varchar $organizationAddress1
	 **/
	private $organizationAddress1;
	/*
	 * Secondary address line of the organization profile. (optional)
	 * @var varchar $organizationAddress2
	 **/
	private $organizationAddress2;
	/*
	 * City for address of the organization profile.
	 * @var varchar $organizationCity
	 **/
	private $organizationCity;
	/*
	 * Email address of the organization profile.
	 * @var varchar $organizationEmail
	 **/
	private $organizationEmail;
	/*
	 * Official City License to operate of the organization.
	 * @var varchar $organizationLicense
	 **/
	private $organizationLicense;
	/*
	 * Official name of the organization.
	 * @var varchar $organizationName
	 **/
	private $organizationName;
	/*
	 * Phone number of the organization.
	 * @var varchar $organizationPhone
	 **/
	private $organizationPhone;
	/*
	 * State for address of the organization profile.
	 * @var char $organizationState
	 **/
	private $organizationState;
	/*
	 * Zip code for address of the organization profile.
	 * @var char $organizationZip
	 **/
	private $organizationZip;
	/*
	 * Constructor for this Organization
	 * @param int|null $newOrganizationId id of this Organization or null if a new Organization
	 * @param int $newOrganizationProfileId id of the Profile that administers the Organization's profile and posts.
	 * @param char|null $newOrganizationActivationToken activation token to authorize the use of the organization profile.
	 * @param string $newOrganizationAddress1 Primary address line of the Organization.
	 * @param string $newOrganizationAddress2 Secondary address line of the Organization.
	 * @param string $newOrganizationCity City for address of the Organization.
	 * @param string $newOrganizationEmail Email of the Organization.
	 * @param string $newOrganizationLicense License of the Organization.
	 * @param string $newOrganizationName Official name of the Organization.
	 * @param string $newOrganizationPhone Phone number of the Organization.
	 * @param char $newOrganizationState State for address of the Organization.
	 * @param char $newOrganizationZip Zip code for address of the Organization.
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 *
	 * */


	/**
	 * formats the state variables for JSON serialization
	 *
	 * @return array resulting state variables to serialize
	 **/
	public function jsonSerialize() {
		$fields = get_object_vars($this);
		return($fields);
	}
}
