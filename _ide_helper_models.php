<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Babysitter
 *
 * @property int $id
 * @property string|null $join_reason_text
 * @property int|null $experience_years
 * @property string|null $experience_age_groups
 * @property \Illuminate\Support\Carbon|null $interview_date
 * @property \Illuminate\Support\Carbon|null $first_aid_passed
 * @property \Illuminate\Support\Carbon|null $first_aid_expiry
 * @property \Illuminate\Support\Carbon|null $criminal_record_check_expiry
 * @property int $jobs_babysitter
 * @property int $jobs_holiday_nanny
 * @property string|null $holiday_nanny_travel_countries
 * @property string|null $profile_content
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property int $published
 * @property string|null $found_source
 * @property string|null $join_reasons
 * @property int $status_id
 * @property string|null $profile_background
 * @property string|null $interview_time
 * @property int $reg_step_1_completed
 * @property int $reg_step_2_completed
 * @property int $reg_step_3_completed
 * @property int $reg_step_4_completed
 * @property int $reg_form_submitted
 * @property int $has_valid_qualifications
 * @property int $has_valid_id
 * @property int $has_valid_references
 * @property int $interview_successful
 * @property string|null $video_url
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BabysitterAddress[] $addresses
 * @property-read int|null $addresses_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BabysitterAvailability[] $availability
 * @property-read int|null $availability_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BabysitterAvailability[] $availabilityBabysitterOnly
 * @property-read int|null $availability_babysitter_only_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BabysitterAvailability[] $availabilityHolidayNannyOnly
 * @property-read int|null $availability_holiday_nanny_only_count
 * @property-read \App\Models\BabysitterBankDetail|null $bank
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BabysitterBookedAvailability[] $bookedAvailability
 * @property-read int|null $booked_availability_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Booking[] $bookings
 * @property-read int|null $bookings_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BabysitterExperienceAgeGroup[] $experienceAgeGroups
 * @property-read int|null $experience_age_groups_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\A17\Twill\Models\File[] $files
 * @property-read int|null $files_count
 * @property-read mixed $completed_registration_as_icon
 * @property-read float|int $reviews_average
 * @property-read int $reviews_number
 * @property-read mixed $successful_interview_as_icon
 * @property-read mixed $valid_id_as_icon
 * @property-read mixed $valid_qualifications_as_icon
 * @property-read mixed $valid_references_as_icon
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BookingInvoice[] $invoices
 * @property-read int|null $invoices_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BabysitterJoinReason[] $joinReasons
 * @property-read int|null $join_reasons_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BabysitterLanguage[] $languages
 * @property-read int|null $languages_count
 * @property-read \App\Models\BabysitterAddress $mainAddress
 * @property-read \Illuminate\Database\Eloquent\Collection|\A17\Twill\Models\Media[] $medias
 * @property-read int|null $medias_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BabysitterReview[] $reviews
 * @property-read int|null $reviews_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BabysitterReview[] $reviewsAverage
 * @property-read int|null $reviews_average_count
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BabysitterSkill[] $skills
 * @property-read int|null $skills_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cartalyst\Tags\IlluminateTag[] $tags
 * @property-read int|null $tags_count
 * @property-read \App\Models\BabysitterAddress $temporaryAddress
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Babysitter acceptsBabysitterJobs()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Babysitter acceptsNannyJobs()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Babysitter active()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Babysitter disabled()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Babysitter newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Babysitter newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Babysitter query()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Babysitter whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Babysitter whereCriminalRecordCheckExpiry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Babysitter whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Babysitter whereExperienceAgeGroups($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Babysitter whereExperienceYears($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Babysitter whereFirstAidExpiry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Babysitter whereFirstAidPassed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Babysitter whereFoundSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Babysitter whereHasValidId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Babysitter whereHasValidQualifications($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Babysitter whereHasValidReferences($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Babysitter whereHolidayNannyTravelCountries($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Babysitter whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Babysitter whereInterviewDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Babysitter whereInterviewSuccessful($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Babysitter whereInterviewTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Babysitter whereJobsBabysitter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Babysitter whereJobsHolidayNanny($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Babysitter whereJoinReasonText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Babysitter whereJoinReasons($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Babysitter whereProfileBackground($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Babysitter whereProfileContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Babysitter wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Babysitter whereRegFormSubmitted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Babysitter whereRegStep1Completed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Babysitter whereRegStep2Completed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Babysitter whereRegStep3Completed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Babysitter whereRegStep4Completed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Babysitter whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model whereTag($tags, $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Babysitter whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Babysitter whereVideoUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model withTag($tags, $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model withoutTag($tags, $type = 'slug')
 */
	class Babysitter extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BabysitterAddress
 *
 * @property int $id
 * @property int $babysitter_id
 * @property int $home_address
 * @property string $address1
 * @property string|null $address2
 * @property string $town
 * @property string $postcode
 * @property string $country
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Babysitter $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterAddress newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BabysitterAddress onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterAddress query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterAddress whereAddress1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterAddress whereAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterAddress whereBabysitterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterAddress whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterAddress whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterAddress whereHomeAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterAddress wherePostcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterAddress whereTown($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterAddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BabysitterAddress withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BabysitterAddress withoutTrashed()
 */
	class BabysitterAddress extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BabysitterAvailability
 *
 * @property int $id
 * @property int $babysitter_id
 * @property string $date
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Babysitter $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterAvailability babysitterOnly()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterAvailability holidayNannyOnly()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterAvailability listAvailable($array)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterAvailability newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterAvailability newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BabysitterAvailability onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterAvailability query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterAvailability whereBabysitterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterAvailability whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterAvailability whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterAvailability whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterAvailability whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BabysitterAvailability withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BabysitterAvailability withoutTrashed()
 */
	class BabysitterAvailability extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BabysitterBankDetail
 *
 * @property int $id
 * @property int $babysitter_id
 * @property string $currency
 * @property string $name
 * @property string $transferwise_type
 * @property string|null $sort_code
 * @property string|null $account_number
 * @property string|null $iban
 * @property string|null $address1
 * @property string|null $address2
 * @property string|null $town
 * @property string|null $postcode
 * @property string|null $state
 * @property string|null $country
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $transferwise_account_id
 * @property string|null $account_type
 * @property-read \App\Models\Babysitter $babysitter
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterBankDetail newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterBankDetail newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BabysitterBankDetail onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterBankDetail query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterBankDetail whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterBankDetail whereAccountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterBankDetail whereAddress1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterBankDetail whereAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterBankDetail whereBabysitterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterBankDetail whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterBankDetail whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterBankDetail whereCurrency($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterBankDetail whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterBankDetail whereIban($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterBankDetail whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterBankDetail whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterBankDetail wherePostcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterBankDetail whereSortCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterBankDetail whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterBankDetail whereTown($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterBankDetail whereTransferwiseAccountId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterBankDetail whereTransferwiseType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterBankDetail whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BabysitterBankDetail withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BabysitterBankDetail withoutTrashed()
 */
	class BabysitterBankDetail extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BabysitterBookedAvailability
 *
 * @property int $id
 * @property int $babysitter_id
 * @property string $date
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Babysitter $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterBookedAvailability babysitterOnly()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterBookedAvailability holidayNannyOnly()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterBookedAvailability listBooked($array)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterBookedAvailability newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterBookedAvailability newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BabysitterBookedAvailability onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterBookedAvailability query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterBookedAvailability whereBabysitterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterBookedAvailability whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterBookedAvailability whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterBookedAvailability whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterBookedAvailability whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BabysitterBookedAvailability withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BabysitterBookedAvailability withoutTrashed()
 */
	class BabysitterBookedAvailability extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BabysitterExperienceAgeGroup
 *
 * @property int $id
 * @property int $babysitter_id
 * @property string $age_group
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterExperienceAgeGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterExperienceAgeGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterExperienceAgeGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterExperienceAgeGroup whereAgeGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterExperienceAgeGroup whereBabysitterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterExperienceAgeGroup whereId($value)
 */
	class BabysitterExperienceAgeGroup extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BabysitterJoinReason
 *
 * @property int $id
 * @property int $babysitter_id
 * @property string $reason
 * @property-read \App\Models\Babysitter $babysitter
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterJoinReason newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterJoinReason newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterJoinReason query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterJoinReason whereBabysitterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterJoinReason whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterJoinReason whereReason($value)
 */
	class BabysitterJoinReason extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BabysitterLanguage
 *
 * @property int $id
 * @property int $babysitter_id
 * @property string $language_name
 * @property string $language_level
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\A17\Twill\Models\File[] $files
 * @property-read int|null $files_count
 * @property-read mixed $level_name
 * @property-read \Illuminate\Database\Eloquent\Collection|\A17\Twill\Models\Media[] $medias
 * @property-read int|null $medias_count
 * @property-read \App\Models\Babysitter $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterLanguage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterLanguage newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BabysitterLanguage onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterLanguage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterLanguage whereBabysitterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterLanguage whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterLanguage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterLanguage whereLanguageLevel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterLanguage whereLanguageName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BabysitterLanguage withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BabysitterLanguage withoutTrashed()
 */
	class BabysitterLanguage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BabysitterPayout
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $published
 * @property int|null $invoice_id
 * @property int|null $amount
 * @property int $bank_details_id
 * @property int|null $transferwise_payment_id
 * @property-read \App\Models\BabysitterBankDetail $bank_details
 * @property-read mixed $amount_formatted
 * @property-read mixed $amount_formatted_coloured
 * @property-read mixed $amount_in_pounds
 * @property-read mixed $invoice_id_with_link
 * @property-read mixed $status
 * @property-read \App\Models\BookingInvoice|null $invoice
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cartalyst\Tags\IlluminateTag[] $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterPayout newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterPayout newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterPayout query()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterPayout whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterPayout whereBankDetailsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterPayout whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterPayout whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterPayout whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterPayout whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterPayout wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model whereTag($tags, $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterPayout whereTransferwisePaymentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterPayout whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model withTag($tags, $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model withoutTag($tags, $type = 'slug')
 */
	class BabysitterPayout extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BabysitterReview
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $published
 * @property string|null $title
 * @property string|null $description
 * @property int|null $babysitter_id
 * @property int|null $booking_id
 * @property int|null $score
 * @property-read \App\Models\Babysitter|null $babysitter
 * @property-read \App\Models\Booking|null $booking
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cartalyst\Tags\IlluminateTag[] $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterReview newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterReview newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterReview query()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterReview whereBabysitterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterReview whereBookingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterReview whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterReview whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterReview whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterReview whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterReview wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterReview whereScore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model whereTag($tags, $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterReview whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterReview whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model withTag($tags, $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model withoutTag($tags, $type = 'slug')
 */
	class BabysitterReview extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BabysitterReviewRequest
 *
 * @property-read \App\Models\Booking $booking
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterReviewRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterReviewRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterReviewRequest query()
 */
	class BabysitterReviewRequest extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BabysitterSkill
 *
 * @property int $id
 * @property int $babysitter_id
 * @property string $skill_code
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterSkill newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterSkill newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BabysitterSkill onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterSkill query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterSkill whereBabysitterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterSkill whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterSkill whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BabysitterSkill whereSkillCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BabysitterSkill withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BabysitterSkill withoutTrashed()
 */
	class BabysitterSkill extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Booking
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $family_id
 * @property int $babysitter_id
 * @property string $type
 * @property \Illuminate\Support\Carbon $start
 * @property \Illuminate\Support\Carbon $end
 * @property int $status_id
 * @property int|null $booking_address_id
 * @property int $contactable_main_phone_number
 * @property int $contactable_emergency_phone_number
 * @property string|null $alternative_phone_number
 * @property string|null $parent_location_during_booking
 * @property string|null $booking_notes
 * @property string|null $children_notes
 * @property string|null $start_location
 * @property string|null $end_location
 * @property string|null $start_location_airport
 * @property string|null $destination_town
 * @property int|null $accommodation_booked
 * @property string|null $accommodation_details
 * @property int|null $babysitter_meet
 * @property string|null $babysitter_meet_details
 * @property int|null $travel_trip
 * @property string|null $travel_trip_details
 * @property \Illuminate\Support\Carbon|null $completed_at
 * @property \Illuminate\Support\Carbon|null $parent_completed_at
 * @property \Illuminate\Support\Carbon|null $babysitter_completed_at
 * @property string|null $original_booking_session
 * @property-read \App\Models\Babysitter $babysitter
 * @property-read \App\Models\BookingAddress|null $bookingAddress
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BookingChild[] $bookingChildren
 * @property-read int|null $booking_children_count
 * @property-read \App\Models\BookingStatus|null $bookingStatus
 * @property-read \App\Models\Family $family
 * @property-read mixed $babysitter_marked_as_completed
 * @property-read mixed $booking_type_human_readable
 * @property-read mixed $completed
 * @property-read mixed $created_date
 * @property-read mixed $duration
 * @property-read mixed $end_date
 * @property-read mixed $end_date_full
 * @property-read mixed $id_padded
 * @property-read mixed $id_padded_with_link
 * @property-read mixed $parent_marked_as_completed
 * @property-read mixed $received_payouts
 * @property-read mixed $start_date
 * @property-read mixed $start_date_full
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BookingInvoice[] $invoices
 * @property-read int|null $invoices_count
 * @property-read \App\Models\BabysitterReview|null $review
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cartalyst\Tags\IlluminateTag[] $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking bookingNeedBabysitterAction($babysitter_id)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking cancelledOnly()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking confirmedOnly()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking confirmedOrCompletedOnly()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking currentBookings()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking forBabysitter($babysitter)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking forFamily($family)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking pastBookings()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking upcomingBookings()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereAccommodationBooked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereAccommodationDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereAlternativePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereBabysitterCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereBabysitterId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereBabysitterMeet($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereBabysitterMeetDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereBookingAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereBookingNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereChildrenNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereContactableEmergencyPhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereContactableMainPhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereDestinationTown($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereEndLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereFamilyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereOriginalBookingSession($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereParentCompletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereParentLocationDuringBooking($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereStartLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereStartLocationAirport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model whereTag($tags, $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereTravelTrip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereTravelTripDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Booking whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model withTag($tags, $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model withoutTag($tags, $type = 'slug')
 */
	class Booking extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BookingAddress
 *
 * @property int $id
 * @property string $building
 * @property string $address1
 * @property string $address2
 * @property string $town
 * @property string $postcode
 * @property string $country
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookingAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookingAddress newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BookingAddress onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookingAddress query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookingAddress whereAddress1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookingAddress whereAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookingAddress whereBuilding($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookingAddress whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookingAddress whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookingAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookingAddress wherePostcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookingAddress whereTown($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BookingAddress withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BookingAddress withoutTrashed()
 */
	class BookingAddress extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BookingChild
 *
 * @property int $id
 * @property int $booking_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $dob
 * @property-read \App\Models\FamilyChild|null $details
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookingChild newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookingChild newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BookingChild onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookingChild query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookingChild whereBookingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookingChild whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookingChild whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookingChild whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookingChild whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BookingChild withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\BookingChild withoutTrashed()
 */
	class BookingChild extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BookingInvoice
 *
 * @property int $id
 * @property int $booking_id
 * @property int $amount_paid
 * @property int $amount_due
 * @property string $type
 * @property string $reference
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $paid_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $published
 * @property array $babysitter_address
 * @property array $family_address
 * @property-read \App\Models\Babysitter|null $babysitter
 * @property-read \App\Models\Booking $booking
 * @property-read \App\Models\Family|null $family
 * @property-read mixed $admin_earning_current_formatted
 * @property-read mixed $admin_earning_formatted
 * @property-read mixed $admin_earnings
 * @property-read mixed $admin_earnings_current
 * @property-read mixed $admin_earnings_current_in_pounds
 * @property-read mixed $admin_earnings_for_booking
 * @property-read mixed $admin_earnings_for_booking_in_pounds
 * @property-read mixed $admin_earnings_in_pounds
 * @property-read mixed $amount_due_formatted
 * @property-read mixed $amount_due_in_pounds
 * @property-read mixed $amount_paid_formatted
 * @property-read mixed $amount_paid_in_pounds
 * @property-read mixed $babysitter_earning_formatted
 * @property-read mixed $babysitter_earnings
 * @property-read mixed $babysitter_earnings_for_booking
 * @property-read mixed $babysitter_earnings_for_booking_in_pounds
 * @property-read mixed $babysitter_earnings_in_pounds
 * @property-read mixed $balance
 * @property-read mixed $balance_formatted
 * @property-read mixed $balance_in_pounds
 * @property-read mixed $balance_status
 * @property-read mixed $created_date
 * @property-read \App\Models\BabysitterPayout|null $payout
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cartalyst\Tags\IlluminateTag[] $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookingInvoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookingInvoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookingInvoice query()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookingInvoice whereAmountDue($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookingInvoice whereAmountPaid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookingInvoice whereBabysitterAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookingInvoice whereBookingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookingInvoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookingInvoice whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookingInvoice whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookingInvoice whereFamilyAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookingInvoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookingInvoice wherePaidAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookingInvoice wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookingInvoice whereReference($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model whereTag($tags, $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookingInvoice whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookingInvoice whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model withTag($tags, $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model withoutTag($tags, $type = 'slug')
 */
	class BookingInvoice extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BookingStatus
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cartalyst\Tags\IlluminateTag[] $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookingStatus getNewBookingStatus()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookingStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookingStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookingStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookingStatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookingStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BookingStatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model whereTag($tags, $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model withTag($tags, $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model withoutTag($tags, $type = 'slug')
 */
	class BookingStatus extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Chat
 *
 * @property int $id
 * @property int|null $sender_id
 * @property int|null $recipient_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $booking_id
 * @property-read \App\Models\Booking|null $booking
 * @property-read mixed $last_message_date
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ChatMessage[] $messages
 * @property-read int|null $messages_count
 * @property-read \App\User|null $recipient
 * @property-read \App\User|null $sender
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cartalyst\Tags\IlluminateTag[] $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chat forAdmin()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chat forBooking($booking)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chat newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chat newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chat query()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chat whereBookingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chat whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chat whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chat whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chat whereRecipientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chat whereSenderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model whereTag($tags, $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Chat whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model withTag($tags, $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model withoutTag($tags, $type = 'slug')
 */
	class Chat extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ChatMessage
 *
 * @property int $id
 * @property int $chat_id
 * @property string $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int|null $added_by
 * @property-read \App\User|null $addedBy
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cartalyst\Tags\IlluminateTag[] $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChatMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChatMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChatMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChatMessage whereAddedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChatMessage whereChatId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChatMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChatMessage whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChatMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChatMessage whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model whereTag($tags, $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\ChatMessage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model withTag($tags, $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model withoutTag($tags, $type = 'slug')
 */
	class ChatMessage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Family
 *
 * @property int $id
 * @property string|null $children_health_problems
 * @property int $published
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property int $reg_step_1_completed
 * @property int $reg_step_2_completed
 * @property int $reg_step_3_completed
 * @property int $reg_form_submitted
 * @property string|null $found_source
 * @property string|null $stripe_id
 * @property-read \App\Models\FamilyAddress|null $address
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Booking[] $bookings
 * @property-read int|null $bookings_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FamilyChild[] $children
 * @property-read int|null $children_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\A17\Twill\Models\File[] $files
 * @property-read int|null $files_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\BookingInvoice[] $invoices
 * @property-read int|null $invoices_count
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cartalyst\Tags\IlluminateTag[] $tags
 * @property-read int|null $tags_count
 * @property-read \App\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Family newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Family newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Family query()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Family whereChildrenHealthProblems($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Family whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Family whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Family whereFoundSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Family whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Family wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Family whereRegFormSubmitted($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Family whereRegStep1Completed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Family whereRegStep2Completed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Family whereRegStep3Completed($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Family whereStripeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model whereTag($tags, $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Family whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model withTag($tags, $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model withoutTag($tags, $type = 'slug')
 */
	class Family extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FamilyAddress
 *
 * @property int $id
 * @property int $family_id
 * @property string $address1
 * @property string|null $address2
 * @property string $town
 * @property string $postcode
 * @property string $country
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Family $family
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FamilyAddress newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FamilyAddress newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FamilyAddress onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FamilyAddress query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FamilyAddress whereAddress1($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FamilyAddress whereAddress2($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FamilyAddress whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FamilyAddress whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FamilyAddress whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FamilyAddress whereFamilyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FamilyAddress whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FamilyAddress wherePostcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FamilyAddress whereTown($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FamilyAddress whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FamilyAddress withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FamilyAddress withoutTrashed()
 */
	class FamilyAddress extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\FamilyChild
 *
 * @property int $id
 * @property int $family_id
 * @property string $name
 * @property \Illuminate\Support\Carbon $dob
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Family $family
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FamilyChild newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FamilyChild newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FamilyChild onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FamilyChild query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FamilyChild whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FamilyChild whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FamilyChild whereFamilyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FamilyChild whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FamilyChild whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FamilyChild withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FamilyChild withoutTrashed()
 */
	class FamilyChild extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\InterviewAvailability
 *
 * @property int $id
 * @property string $date
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InterviewAvailability newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InterviewAvailability newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InterviewAvailability query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InterviewAvailability whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\InterviewAvailability whereId($value)
 */
	class InterviewAvailability extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Page
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $published
 * @property string|null $title
 * @property string|null $subtitle
 * @property string|null $meta_title
 * @property string|null $meta_desc
 * @property string|null $system_hook
 * @property-read \Illuminate\Database\Eloquent\Collection|\A17\Twill\Models\Block[] $blocks
 * @property-read int|null $blocks_count
 * @property-read mixed $slug
 * @property-read \Illuminate\Database\Eloquent\Collection|\A17\Twill\Models\Media[] $medias
 * @property-read int|null $medias_count
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Slideshow[] $slideshows
 * @property-read int|null $slideshows_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Slugs\PageSlug[] $slugs
 * @property-read int|null $slugs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cartalyst\Tags\IlluminateTag[] $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page forFallbackLocaleSlug($slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page forHook($hook_name)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page forInactiveSlug($slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page forSlug($slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page query()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereMetaDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereSubtitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereSystemHook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model whereTag($tags, $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Page whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model withTag($tags, $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model withoutTag($tags, $type = 'slug')
 */
	class Page extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Post
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $published
 * @property string|null $title
 * @property string|null $description
 * @property string|null $meta_title
 * @property string|null $meta_desc
 * @property-read \Illuminate\Database\Eloquent\Collection|\A17\Twill\Models\Block[] $blocks
 * @property-read int|null $blocks_count
 * @property-read mixed $slug
 * @property-read \Illuminate\Database\Eloquent\Collection|\A17\Twill\Models\Media[] $medias
 * @property-read int|null $medias_count
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Slugs\PostSlug[] $slugs
 * @property-read int|null $slugs_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cartalyst\Tags\IlluminateTag[] $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post forFallbackLocaleSlug($slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post forInactiveSlug($slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post forSlug($slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereMetaDesc($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model whereTag($tags, $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Post whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model withTag($tags, $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model withoutTag($tags, $type = 'slug')
 */
	class Post extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Slideshow
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $published
 * @property string|null $title
 * @property string|null $description
 * @property string|null $colour
 * @property int|null $page_id
 * @property int|null $position
 * @property-read \Illuminate\Database\Eloquent\Collection|\A17\Twill\Models\Media[] $medias
 * @property-read int|null $medias_count
 * @property-read \App\Models\Page $pages
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cartalyst\Tags\IlluminateTag[] $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slideshow newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slideshow newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slideshow ordered()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slideshow query()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slideshow whereColour($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slideshow whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slideshow whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slideshow whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slideshow whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slideshow wherePageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slideshow wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slideshow wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model whereTag($tags, $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slideshow whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slideshow whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model withTag($tags, $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model withoutTag($tags, $type = 'slug')
 */
	class Slideshow extends \Eloquent {}
}

namespace App\Models\Slugs{
/**
 * App\Models\Slugs\PageSlug
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $slug
 * @property string $locale
 * @property int $active
 * @property int $page_id
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cartalyst\Tags\IlluminateTag[] $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slugs\PageSlug newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slugs\PageSlug newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slugs\PageSlug query()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slugs\PageSlug whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slugs\PageSlug whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slugs\PageSlug whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slugs\PageSlug whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slugs\PageSlug whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slugs\PageSlug wherePageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slugs\PageSlug whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model whereTag($tags, $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slugs\PageSlug whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model withTag($tags, $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model withoutTag($tags, $type = 'slug')
 */
	class PageSlug extends \Eloquent {}
}

namespace App\Models\Slugs{
/**
 * App\Models\Slugs\PostSlug
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $slug
 * @property string $locale
 * @property int $active
 * @property int $post_id
 * @property-write mixed $publish_start_date
 * @property-read \Illuminate\Database\Eloquent\Collection|\Cartalyst\Tags\IlluminateTag[] $tags
 * @property-read int|null $tags_count
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model draft()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slugs\PostSlug newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slugs\PostSlug newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model published()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model publishedInListings()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slugs\PostSlug query()
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model visible()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slugs\PostSlug whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slugs\PostSlug whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slugs\PostSlug whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slugs\PostSlug whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slugs\PostSlug whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slugs\PostSlug wherePostId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slugs\PostSlug whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model whereTag($tags, $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Slugs\PostSlug whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model withTag($tags, $type = 'slug')
 * @method static \Illuminate\Database\Eloquent\Builder|\A17\Twill\Models\Model withoutTag($tags, $type = 'slug')
 */
	class PostSlug extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string|null $role
 * @property string $email
 * @property string|null $password
 * @property string $phone_number
 * @property string $home_phone_number
 * @property string $emergency_name
 * @property string $emergency_relationship
 * @property string $emergency_phone_number
 * @property \Illuminate\Support\Carbon|null $dob
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property string|null $provider
 * @property string|null $provider_id
 * @property-read \App\Models\Babysitter $babysitter
 * @property-read \App\Models\Family $family
 * @property-read mixed $full_name
 * @property-read mixed $full_name_with_link
 * @property-read string $slug
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User hasSlug($slug)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Query\Builder|\App\User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmergencyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmergencyPhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmergencyRelationship($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereHomePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereProvider($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereProviderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereSurname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\User withoutTrashed()
 */
	class User extends \Eloquent {}
}

