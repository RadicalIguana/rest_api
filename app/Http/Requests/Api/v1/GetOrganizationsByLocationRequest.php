<?php

namespace App\Http\Requests\Api\v1;

use Illuminate\Foundation\Http\FormRequest;

class GetOrganizationsByLocationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'lat' => ['required', 'numeric', 'between:-90,90'],
            'lng' => ['required', 'numeric', 'between:-180,180'],
            'radius' => ['nullable', 'numeric', 'min:0.1'],
            'north_east_lat' => ['nullable', 'numeric', 'between:-90,90'],
            'north_east_lng' => ['nullable', 'numeric', 'between:-180,180'],
            'south_west_lat' => ['nullable', 'numeric', 'between:-90,90'],
            'south_west_lng' => ['nullable', 'numeric', 'between:-180,180'],
        ];
    }

    public function messages(): array
    {
        return [
            'lat.between' => 'Latitude must be between -90 and 90.',
            'lng.between' => 'Longitude must be between -180 and 180.',
        ];
    }

    public function getLat(): float
    {
        return (float) $this->validated('lat');
    }

    public function getLng(): float
    {
        return (float) $this->validated('lng');
    }

    public function getRadius(): ?float
    {
        return $this->validated('radius') ? (float) $this->validated('radius') : null;
    }

    public function getBounds(): ?array
    {
        if ($this->filled(['north_east_lat', 'north_east_lng', 'south_west_lat', 'south_west_lng'])) {
            return [
                'north_east' => [
                    'lat' => (float) $this->validated('north_east_lat'),
                    'lng' => (float) $this->validated('north_east_lng'),
                ],
                'south_west' => [
                    'lat' => (float) $this->validated('south_west_lat'),
                    'lng' => (float) $this->validated('south_west_lng'),
                ],
            ];
        }

        return null;
    }
}
