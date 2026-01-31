<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Applicant Details</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.4; color: #333; max-width: 800px; margin: 20px auto; border: 1px solid #ccc; padding: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        h1 { margin: 0; font-size: 24px; text-transform: uppercase; }
        .section-title { background-color: #f2f2f2; font-weight: bold; padding: 5px; margin-top: 15px; border: 1px solid #ddd; text-transform: uppercase; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; font-size: 13px; }
        .label { font-weight: bold; background-color: #fafafa; width: 25%; }
        .photo-box { width: 120px; height: 150px; border: 1px solid #000; text-align: center; display: flex; align-items: center; justify-content: center; }
    </style>
</head>
<body>

    <div class="header">
        <div>
            <strong>EUROPATH FOREIGN EMPLOYMENT</strong><br>
            <span>Date: 12/01/2026</span>
        </div>
        <h1>Applicant Details</h1>
        <div class="photo-box"><img src="{{ asset('storage/app/public/'.$candidate->photo) }}" alt="Candidate Photo" class="img-thumbnail"></div>
    </div>

    <table>
        <tr>
            <td class="label">REG NO</td><td>{{ $candidate->full_name }}</td>
            <td class="label">REF NO</td><td>{{ $candidate->full_name }}</td>
        </tr>
        <tr>
            <td class="label">APPLIED POSITION</td><td colspan="3">KITCHEN HELPER</td>
        </tr>
    </table>

    <div class="section-title">PERSONAL INFORMATION</div>
    <table>
        <tr>
            <td class="label">NAME IN FULL</td><td colspan="3">{{ $candidate->full_name }}</td>
        </tr>
        <tr>
            <td class="label">ADDRESS</td><td colspan="3">{{ $candidate->full_name }}</td>
        </tr>
        <tr>
            <td class="label">PASSPORT NO</td><td>{{ $candidate->full_name }}</td>
            <td class="label">NIC NO</td><td>{{ $candidate->full_name }}</td>
        </tr>
        <tr>
            <td class="label">DATE OF BIRTH</td><td>{{ $candidate->full_name }}</td>
            <td class="label">EMAIL ADDRESS</td><td></td>
        </tr>
        <tr>
            <td class="label">PLACE OF BIRTH</td><td>{{ $candidate->full_name }}</td>
            <td class="label">CIVIL STATUS</td><td>{{ $candidate->full_name }}</td>
        </tr>
        <tr>
            <td class="label">AGE</td><td>{{ $candidate->full_name }}</td>
            <td class="label">NO OF CHILDREN</td><td>{{ $candidate->full_name }}</td>
        </tr>
        <tr>
            <td class="label">HEIGHT</td><td>{{ $candidate->full_name }} CM</td>
            <td class="label">NATIONALITY</td><td>{{ $candidate->full_name }}</td>
        </tr>
        <tr>
            <td class="label">WEIGHT</td><td>{{ $candidate->full_name }} Kg</td>
            <td class="label">RELIGION</td><td>{{ $candidate->full_name }}</td>
        </tr>
        <tr>
            <td class="label">FATHER NAME</td><td colspan="3">{{ $candidate->full_name }}</td>
        </tr>
        <tr>
            <td class="label">MOTHER NAME</td><td colspan="3">{{ $candidate->full_name }}</td>
        </tr>
    </table>

    <div class="section-title">EDUCATIONAL QUALIFICATIONS</div>
    <table>
        <tr>
            <th style="width: 40%;">INSTITUTE</th>
            <th style="width: 40%;">COURSE</th>
            <th style="width: 20%;">DURATION</th>
        </tr>
        <tr>
            <td>GOVERNMENT COLLEGE</td>
            <td>PASSED G.C.E O/L EXAM</td>
            <td></td>
        </tr>
    </table>

    <div class="section-title">PROFESSIONAL EXERIENCE</div>
    <table>
        <tr>
            <th style="width: 40%;">EMPLOYER</th>
            <th style="width: 40%;">POSITION</th>
            <th style="width: 20%;">DURATION</th>
        </tr>
        <tr>
            <td>FRENCH VILLA IN SRI LANKA</td>
            <td>KITCHEN HELPER</td>
            <td>06 YEARS</td>
        </tr>
        <tr>
            <td>SURIYA RESORT IN SRI LANKA</td>
            <td>DISH WASHER</td>
            <td>04 YEARS</td>
        </tr>
    </table>

    <div class="section-title">Language Proficiency (English)</div>
    <table>
        <tr><td class="label">UNDERSTANDING</td><td>GOOD</td></tr>
        <tr><td class="label">SPEAKING</td><td>GOOD</td></tr>
        <tr><td class="label">WRITING</td><td>GOOD</td></tr>
    </table>

    <div style="margin-top: 30px; font-size: 12px; text-align: center; border-top: 1px solid #eee; padding-top: 10px;">
        <p>I DECLARE ON MY OWN RESPONSIBILITY THAT I AM MEDICALLY FIT TO WORK AND THAT I HAVE A MINIMUM KNOWLEDGE OF ROMANIAN AND ENGLISH.</p>
        <div style="display: flex; justify-content: space-between; margin-top: 40px;">
            <span>DATE: ____________________</span>
            <span>SIGNATURE: ____________________</span>
        </div>
    </div>

</body>
</html>
