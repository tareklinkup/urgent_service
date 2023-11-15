@extends("layouts.master")

@push('style')
<style>
    .privatecar_category {
        text-decoration: none;
        display: block;
        list-style: none;
        padding: 3px;
        font-family: auto;
        border-bottom: 1px dashed #d1d1d1;
        color: #626262;
        transition: 2ms ease-in-out;
    }

    .privatecar_category:hover {
        color: red !important;
    }
</style>
@endpush
@section("content")
<section id="doctor-details" style="padding: 25px 0;">
    <div class="container">
        <div class="doctordetail-header mb-3">
            <div class="row d-flex justify-content-center align-items-center">
                <div class="col-md-10 col-10">
                    <form id="filterPrivatecar" class="form">
                        <div class="row d-flex justify-content-center">
                            <div class="col-md-3 col-10">
                                <div class="form-group mb-4 mb-md-0">
                                    <label for="city" class="d-md-block d-none">City</label>
                                    <select class="rounded-pill" name="city" id="city">
                                        <option label="Select City"></option>
                                        @foreach($cities as $city)
                                        <option value="{{$city->id}}">{{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-10">
                                <div class="form-group">
                                    <label for="privatecar_type" class="d-md-block d-none">Type Of Ambulance</label>
                                    <select class="rounded-pill" name="privatecar_type" id="privatecar_type">
                                        <option label="Select Ambulance Type"></option>
                                        @foreach($cartypes as $item)
                                        <option value="{{$item->id}}">{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3 col-10">
                                <div class="form-group">
                                    <label for="privatecar_name" class="d-md-block d-none">Ambulance Name</label>
                                    <input type="text" name="privatecar_name" id="privatecar_name" class="form-control" autocomplete="off" style="height: 33px;border-radius: 2rem;background: black;border: 0;box-shadow: none;color: #a3a3a3;padding-left: 18px;padding-top: 3px;">
                                </div>
                            </div>
                            <div class="col-md-3 col-6">
                                <div class="form-group text-center pt-4">
                                    <button type="submit" class="btn text-white rounded-pill">Search</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row m-md-0" style="border: 1px solid #e5e5e5;">
            <div class="col-md-3 p-md-0 order-md-0 order-last">
                <div class="card border-0" style="border-radius: 0;height:100%;border-right: 1px solid #e3e3e3 !important;">
                    <div class="card-header" style="border: none;border-radius: 0;background: #e3e3e3;">
                        <h6 class="card-title text-uppercase m-0" style="color:#832a00;">CarType List</h6>
                    </div>
                    <div class="card-body" style="padding-top: 3px;">
                        <a title="All" href="{{route('privatecar.details')}}" class="privatecar_category {{$type_id != null ? '' : 'text-danger'}}">All</a>
                        @foreach($categories as $item)
                        <a title="{{$item->name}}" href="{{route('privatecar.details', ['type', 'id' => $item->id])}}" class="privatecar_category {{$type_id == $item->id ? 'text-danger': ''}}">{{$item->name}} <span class="text-danger" style="font-weight:700;">({{$item->typewiseprivatecar->count()}})</span></a>
                        @endforeach

                        <!-- city list -->
                        <div class="mt-5" style="border: none;border-radius: 0;background: #e3e3e3;padding:7px;">
                            <h6 class="title text-uppercase m-0" style="color:#832a00;">City List</h6>
                        </div>
                        <div style="height: 400px;overflow-y: scroll;">
                            @foreach($cities as $item)
                            <a title="{{$item->name}}" href="{{route('privatecar.details',['city', 'id' => $item->id])}}" class="privatecar_category {{$item->id == $city_id ? 'text-danger' : ''}}">{{$item->name}} <span class="text-danger" style="font-weight:700;">({{$item->privatecar->count()}})</span></a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-9 doctor_details">
                <h5 class="m-0 totalDoctorcount" style="text-align: right;font-family: auto;font-style: italic;">Total: <span>{{$data['privatecar']->count()}}</span></h5>
                <div class="row py-2 privatecarbody">

                    @foreach($data['privatecar'] as $item)
                    @if($item->privatecar != null)
                    <div class="col-md-6 mb-3">
                        <a href="{{route('singlepageprivatecar', $item->privatecar->id)}}" target="_blank" class="text-decoration-none text-secondary" title="{{$item->privatecar->name}}">
                            <div class="card" style="border-radius: 0;border: 0;font-family: auto;box-shadow: 0px 0px 8px 0px #bfbfbfbf;height:130px;">
                                <div class="card-body d-flex" style="padding: 5px;gap: 8px;">
                                    <div class="image" style="border: 1px dotted #ababab;height: 110px;margin-top: 4px;">
                                        <img src="{{asset($item->privatecar->image != '0' ? $item->privatecar->image:'/frontend/img/privatecar.png')}}" width="100" height="100%">
                                    </div>
                                    <div class="info" style="padding-right:5px;">
                                        <h6>{{$item->privatecar->name}}</h6>
                                        <p style="color:#c99913;">{{$item->cartype->name}}, {{$item->privatecar->city->name}}</p>
                                        <p style="border-top: 2px dashed #dddddd85;text-align:justify;"><i class="fa fa-map-marker"></i> {{mb_strimwidth($item->privatecar->address, 0, 100, "...")}}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endif
                    @endforeach

                    @if($city_id == null)
                    {{$data['privatecar']->links('vendor.pagination.simple-bootstrap-4')}}
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push("js")
<script>
    function Row(index, value) {
        var row = `
                    <div class="col-md-6 mb-3">
                        <a href="/single-details-privatecar/${value.privatecar_id}" target="_blank" class="text-decoration-none text-secondary" title="${value.name}">
                            <div class="card" style="border-radius: 0;border: 0;font-family: auto;box-shadow: 0px 0px 8px 0px #bfbfbfbf;height:130px;">
                                <div class="card-body d-flex" style="padding: 5px;gap: 8px;">
                                    <div class="image" style="border: 1px dotted #ababab;height: 110px;margin-top: 4px;">
                                        <img src="${value.image != '0' ? '/'+value.image:'/frontend/img/privatecar.png'}" width="100" height="100%">
                                    </div>
                                    <div class="info" style="padding-right:5px;">
                                        <h6>${value.name}</h6>
                                        <p style="color:#c99913;">${value.cartype}, ${value.city_name}</p>
                                        <p style="border-top: 2px dashed #dddddd85;text-align:justify;"><i class="fa fa-map-marker"></i> ${value.address}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
            `;
        $(".privatecarbody").append(row)

    }

    $("#filterPrivatecar").on("submit", (event) => {
        event.preventDefault();
        var formdata = new FormData(event.target)
        $.ajax({
            url: "{{route('filter.privatecar')}}",
            method: "POST",
            data: formdata,
            contentType: false,
            processData: false,
            beforeSend: () => {
                $(".Loading").removeClass("d-none")
                $(".privatecarbody").html("")
            },
            success: res => {
                if (res.status == true && res.message.length == 0) {
                    $(".totalDoctorcount").find("span").text(res.message.length)
                    $(".privatecarbody").html(`<div class="bg-dark text-white text-center">Not Found Data</div>`)
                } else if (res.status == true) {
                    $(".totalDoctorcount").find("span").text(res.message.length)
                    $.each(res.message, (index, value) => {
                        Row(index, value)
                    })
                } else {
                    $(".privatecarbody").html(`<div class="bg-dark text-white text-center">${res.message}</div>`)
                }
            },
            complete: () => {
                $(".Loading").addClass("d-none")
            }
        })
    })
</script>
@endpush