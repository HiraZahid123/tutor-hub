<?php

namespace App\Models;

use App\Support\CountryCurrency;
use Illuminate\Database\Eloquent\Model;

class TutorRegistration extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'country',
        'city',
        'area',
        'timezone',
        'gender',
        'tutoring_preference',
        'is_online',
        'is_home',
        'hourly_rate',
        'currency',
        'program',
        'major',
        'university',
        'study_year_from',
        'study_year_to',
        'resume_path',
        'profile_image',
        'bio',
        'teaching_experience',
        'latitude',
        'longitude',
        'title',
        'subject',
        'is_approved',
        'status',
        'internal_notes',
        'verification_notes',
        'interview_at',
        'rating',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function availabilities()
    {
        return $this->hasMany(TutorAvailability::class, 'tutor_id');
    }
    
    public function reviews()
    {
        return $this->hasMany(TutorReview::class, 'tutor_id');
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'tutor_registration_subject');
    }

    public function getAverageRatingAttribute()
    {
        return round($this->reviews()->avg('rating') ?: 0, 1);
    }

    public function getReviewCountAttribute()
    {
        return $this->reviews()->count();
    }

    protected $casts = [
        'is_approved' => 'boolean',
        'interview_at' => 'datetime',
        'is_online' => 'boolean',
        'is_home' => 'boolean',
    ];

    public function getDisplayCurrencyAttribute(): string
    {
        return $this->currency ?: CountryCurrency::forCountry($this->country);
    }

    public function getCountryNameAttribute()
    {
        $countries = [
            'PK' => 'Pakistan',
            'AE' => 'UAE',
            'SA' => 'Saudi Arabia',
            'GB' => 'United Kingdom',
            'US' => 'United States',
            'QA' => 'Qatar',
            'KW' => 'Kuwait',
            'BH' => 'Bahrain',
            'OM' => 'Oman',
            'JO' => 'Jordan',
            'EG' => 'Egypt',
            'TR' => 'Turkey',
            'IN' => 'India',
            'BD' => 'Bangladesh',
            'LK' => 'Sri Lanka',
            'MY' => 'Malaysia',
            'SG' => 'Singapore',
            'ID' => 'Indonesia',
            'PH' => 'Philippines',
            'AF' => 'Afghanistan',
            'IR' => 'Iran',
            'IQ' => 'Iraq',
            'YE' => 'Yemen',
            'NG' => 'Nigeria',
            'KE' => 'Kenya',
            'ZA' => 'South Africa',
            'GH' => 'Ghana',
            'TZ' => 'Tanzania',
            'CA' => 'Canada',
            'AU' => 'Australia',
            'NZ' => 'New Zealand',
            'DE' => 'Germany',
            'FR' => 'France',
            'NL' => 'Netherlands',
            'OTHER' => 'Other / International',
        ];

        return $countries[strtoupper($this->country)] ?? $this->country;
    }

    public function getAreaAttribute()
    {
        // Return the stored area value if it exists (new registrations)
        if (!empty($this->attributes['area'])) {
            return $this->attributes['area'];
        }

        // Legacy fallback: derive area from bio/university text (old records)
        $searchString = strtolower($this->university . ' ' . $this->bio . ' ' . $this->teaching_experience);
        if (strtolower($this->country) === 'pk') {
            if (str_contains($searchString, 'karachi')) {
                return 'DHA Karachi';
            } elseif (str_contains($searchString, 'rawalpindi')) {
                return 'Satellite Town';
            } elseif (str_contains($searchString, 'islamabad')) {
                return 'F-6';
            } elseif (str_contains($searchString, 'lahore')) {
                if (str_contains($searchString, 'askari')) {
                    return 'Askari';
                } elseif (str_contains($searchString, 'iqbal town')) {
                    return 'Allama Iqbal Town';
                } elseif (str_contains($searchString, 'rehman garden')) {
                    return 'Al-Rehman Gardens';
                } elseif (str_contains($searchString, 'architect')) {
                    return 'Architect Society';
                } elseif (str_contains($searchString, 'audits')) {
                    return 'Audits and Accounts Society';
                } elseif (str_contains($searchString, 'abdalian')) {
                    return 'Abdalian Society';
                } elseif (str_contains($searchString, 'bahria')) {
                    if (str_contains($searchString, 'orchard')) {
                        return 'Bahria Orchard';
                    } else {
                        return 'Bahria Town';
                    }
                } elseif (str_contains($searchString, 'cantt')) {
                    if (str_contains($searchString, 'walton')) {
                        return 'Walton Cantt';
                    } else {
                        return 'Cantt';
                    }
                } elseif (str_contains($searchString, 'cavalry')) {
                    return 'Cavalry Ground';
                } elseif (str_contains($searchString, 'dha')) {
                    if (str_contains($searchString, 'rahbar')) {
                        return 'DHA Rahbar';
                    } elseif (str_contains($searchString, 'phase 5') || str_contains($searchString, 'phase 6')) {
                        return 'DHA Phase 5,6';
                    } elseif (str_contains($searchString, 'phase 7') || str_contains($searchString, 'phase 8') || str_contains($searchString, 'phase 9')) {
                        return 'DHA Phase 7,8,9';
                    } else {
                        return 'DHA Phase 1,2,3,4';
                    }
                } elseif (str_contains($searchString, 'divine')) {
                    return 'Divine Gardens';
                } elseif (str_contains($searchString, 'eden')) {
                    return 'Eden Society';
                } elseif (str_contains($searchString, 'eme')) {
                    return 'EME Society';
                } elseif (str_contains($searchString, 'ferozpur')) {
                    return 'Ferozpur Road';
                } elseif (str_contains($searchString, 'faisal town')) {
                    return 'Faisal Town';
                } elseif (str_contains($searchString, 'fazaia')) {
                    return 'Fazaia Housing Scheme';
                } elseif (str_contains($searchString, 'formanite')) {
                    return 'Formanites Housing Scheme';
                } elseif (str_contains($searchString, 'gulberg')) {
                    if (str_contains($searchString, 'gulberg 1') || str_contains($searchString, 'gulberg i')) {
                        return 'Gulberg 1';
                    } elseif (str_contains($searchString, 'gulberg 2') || str_contains($searchString, 'gulberg ii')) {
                        return 'Gulberg 2';
                    } elseif (str_contains($searchString, 'gulberg 3') || str_contains($searchString, 'gulberg iii')) {
                        return 'Gulberg 3';
                    } else {
                        return 'Gulberg 1';
                    }
                } elseif (str_contains($searchString, 'garden town')) {
                    if (str_contains($searchString, 'new garden')) {
                        return 'New Garden Town';
                    } else {
                        return 'Garden Town';
                    }
                } elseif (str_contains($searchString, 'gulshan ravi')) {
                    return 'Gulshan Ravi';
                } elseif (str_contains($searchString, 'green town')) {
                    return 'Green Town';
                } elseif (str_contains($searchString, 'gor')) {
                    return 'GOR';
                } elseif (str_contains($searchString, 'harbanspura')) {
                    return 'Harbanspura';
                } elseif (str_contains($searchString, 'izmir')) {
                    return 'Izmir Town';
                } elseif (str_contains($searchString, 'ichra')) {
                    return 'Ichra';
                } elseif (str_contains($searchString, 'iep') || str_contains($searchString, 'engineers town')) {
                    return 'IEP Engineers Town';
                } elseif (str_contains($searchString, 'johar town')) {
                    return 'Johar Town';
                } elseif (str_contains($searchString, 'jubilee')) {
                    return 'Jubilee Town';
                } elseif (str_contains($searchString, 'kot lakhpat')) {
                    return 'Kot Lakhpat';
                } elseif (str_contains($searchString, 'lake city')) {
                    return 'Lake City';
                } elseif (str_contains($searchString, 'model town')) {
                    return 'Model Town';
                } elseif (str_contains($searchString, 'mughalpura') || str_contains($searchString, 'mughal pura')) {
                    return 'Mughalpura';
                } elseif (str_contains($searchString, 'muslim town')) {
                    return 'Muslim Town';
                } elseif (str_contains($searchString, 'mustafa town')) {
                    return 'Mustafa Town';
                } elseif (str_contains($searchString, 'peco')) {
                    return 'Peco Road';
                } elseif (str_contains($searchString, 'raiwind')) {
                    return 'Raiwind Road';
                } elseif (str_contains($searchString, 'revenue')) {
                    return 'Revenue Society';
                } elseif (str_contains($searchString, 'state life')) {
                    return 'State Life Housing Society';
                } elseif (str_contains($searchString, 'samanabad')) {
                    return 'Samanabad';
                } elseif (str_contains($searchString, 'sabzazar')) {
                    return 'Sabzazar';
                } elseif (str_contains($searchString, 'sui gas')) {
                    return 'Sui Gas Society';
                } elseif (str_contains($searchString, 'shadab')) {
                    return 'Shadab Gardens';
                } elseif (str_contains($searchString, 'tajpura')) {
                    return 'Tajpura';
                } elseif (str_contains($searchString, 'thokar')) {
                    return 'Thokar Niaz Baig';
                } elseif (str_contains($searchString, 'township') || str_contains($searchString, 'town ship')) {
                    return 'Town Ship';
                } elseif (str_contains($searchString, 'uet')) {
                    return 'UET Housing Society';
                } elseif (str_contains($searchString, 'valencia')) {
                    return 'Valencia Housing Society';
                } elseif (str_contains($searchString, 'vital')) {
                    return 'Vital Homes Housing Society';
                } elseif (str_contains($searchString, 'wahdat')) {
                    return 'Wahdat Road';
                } elseif (str_contains($searchString, 'wapda town')) {
                    return 'Wapda Town';
                } elseif (str_contains($searchString, 'zaman park')) {
                    return 'Zaman Park';
                } else {
                    return 'Other Area';
                }
            } elseif (str_contains($searchString, 'faisalabad')) {
                return 'Canal Road';
            } elseif (str_contains($searchString, 'multan')) {
                return 'Cantt';
            } elseif (str_contains($searchString, 'peshawar')) {
                return 'Hayatabad';
            } else {
                return 'Other Area';
            }
        } else {
            if (str_contains($searchString, 'jumeirah')) return 'Jumeirah';
            if (str_contains($searchString, 'downtown')) return 'Downtown';
            if (str_contains($searchString, 'barsha')) return 'Al Barsha';
            if (str_contains($searchString, 'yas island') || str_contains($searchString, 'yas')) return 'Yas Island';
            if (str_contains($searchString, 'marina')) return 'Dubai Marina';
            if (str_contains($searchString, 'palm')) return 'Palm Jumeirah';
            if (str_contains($searchString, 'reem')) return 'Al Reem Island';
            if (str_contains($searchString, 'khalifa')) return 'Khalifa City';
            if (str_contains($searchString, 'corniche')) return 'Corniche';
            if (str_contains($searchString, 'majaz')) return 'Al Majaz';
            if (str_contains($searchString, 'nahda')) return 'Al Nahda';
            if (str_contains($searchString, 'muwaileh')) return 'Muwaileh';
            
            if (str_contains($searchString, 'olaya')) return 'Olaya';
            if (str_contains($searchString, 'malaz')) return 'Al Malaz';
            if (str_contains($searchString, 'yasmin')) return 'Al Yasmin';
            if (str_contains($searchString, 'sahafa')) return 'Al Sahafa';
            if (str_contains($searchString, 'muhammadiyah')) return 'Al Muhammadiyah';
            if (str_contains($searchString, 'naeem')) return 'Al Naeem';
            if (str_contains($searchString, 'safa')) return 'Al Safa';
            if (str_contains($searchString, 'obhur')) return 'Obhur';
            
            if (str_contains($searchString, 'westminster')) return 'Westminster';
            if (str_contains($searchString, 'kensington')) return 'Kensington & Chelsea';
            if (str_contains($searchString, 'camden')) return 'Camden';
            if (str_contains($searchString, 'greenwich')) return 'Greenwich';
            if (str_contains($searchString, 'croydon')) return 'Croydon';
            if (str_contains($searchString, 'ealing')) return 'Ealing';
            if (str_contains($searchString, 'edgbaston')) return 'Edgbaston';
            
            if (str_contains($searchString, 'manhattan')) return 'Manhattan';
            if (str_contains($searchString, 'brooklyn')) return 'Brooklyn';
            if (str_contains($searchString, 'queens')) return 'Queens';
            if (str_contains($searchString, 'bronx')) return 'Bronx';
            if (str_contains($searchString, 'staten')) return 'Staten Island';
            if (str_contains($searchString, 'hollywood')) return 'Hollywood';
            if (str_contains($searchString, 'santa monica')) return 'Santa Monica';
            if (str_contains($searchString, 'pasadena')) return 'Pasadena';
            if (str_contains($searchString, 'loop')) return 'Loop';
            if (str_contains($searchString, 'lincoln park')) return 'Lincoln Park';
            
            return 'Other Area';
        }
    }
}
