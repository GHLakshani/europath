
<?php
$headerMenuJson = '{ "quickShortcutJson":[{"title" : "Services","item1" : "base-2 icon-stack-3x color-primary-600","item2" : "base-3 icon-stack-2x color-primary-700", "item3" : "ni ni-settings icon-stack-1x text-white fs-lg" },{"title" : "Account", "item1" : "base-2 icon-stack-3x color-primary-400","item2" : "base-10 text-white icon-stack-1x", "item3" : "ni md-profile color-primary-800 icon-stack-2x"} ,{"title" : "Security", "item1" : "base-9 icon-stack-3x color-success-400","item2":"base-2 icon-stack-2x color-success-500", "item3" : "ni ni-shield icon-stack-1x text-white" },{ "isSpan" : "true","item1" : "base-18 icon-stack-3x color-info-700", "title" : "Calendar", "spanClass" : "position-absolute pos-top pos-left pos-right color-white fs-md mt-2 fw-400","spanText" : "28" },{"title" : "Stats","item1" : "base-7 icon-stack-3x color-info-500","item2" : "base-7 icon-stack-2x color-info-700", "item3" : "ni ni-graph icon-stack-1x text-white" },{"title" : "Messages","item1" : "base-4 icon-stack-3x color-danger-500","item2" : "base-4 icon-stack-1x color-danger-400", "item3" : "ni ni-envelope icon-stack-1x text-white" },{"title" : "Notes","item1" : "base-4 icon-stack-3x color-fusion-400","item2" : "base-5 icon-stack-2x color-fusion-200", "item3" : "fal fa-keyboard icon-stack-1x color-info-50" },{"title" : "Photos","item1" : "base-16 icon-stack-3x color-fusion-500","item2" : "base-10 icon-stack-1x color-primary-50 opacity-30", "item3" : "fal fa-dot-circle icon-stack-1x text-white opacity-85" },{"title" : "Maps","item1" : "base-19 icon-stack-3x color-primary-400","item2" : "base-7 icon-stack-1x fs-xxl color-primary-200", "item3" : "base-7 icon-stack-1x color-primary-500", "item4" : "fal fa-globe icon-stack-1x text-white opacity-85" },{"title" : "Chat","item1" : "base-5 icon-stack-3x color-success-700 opacity-80","item2" : "base-12 icon-stack-2x color-success-700 opacity-30", "item3" : "fal fa-comment-alt icon-stack-1x text-white" },{"title" : "Phone","item1" : "base-5 icon-stack-3x color-warning-600","item2" : "base-7 icon-stack-2x color-warning-800 opacity-50", "item3" : "fal fa-phone icon-stack-1x text-white" },{"title" : "Projects","item1" : "base-6 icon-stack-3x color-danger-600","item2" : "fal fa-chart-line icon-stack-1x text-white" }] }';

$notificationMenuJson = '{ "notificationJson":[{"liClass" : "unread","avatar" : "/img/demo/avatars/avatar-a.png","title" : "Adison Lee","desc" : "Msed quia non numquam eius","min":"2 minutes ago" },{"liClass" : "","avatar" : "/img/demo/avatars/avatar-b.png","title" : "Oliver Kopyuv","desc" : "Msed quia non numquam eius","min":"3 minutes ago" },{"liClass" : "","avatar" : "/img/demo/avatars/avatar-e.png","title" : "Dr. John Cook PhD","desc" : "Msed quia non numquam eius","min":"2 minutes ago" },{"liClass" : "","avatar" : "/img/demo/avatars/avatar-h.png","title" : "Sarah McBrook","desc" : "Msed quia non numquam eius","min":"3 minutes ago" },{"liClass" : "","avatar" : "/img/demo/avatars/avatar-m.png","title" : "Anothony Bezyeth","desc" : "Msed quia non numquam eius","min":"one minutes ago" },{"liClass" : "","avatar" : "/img/demo/avatars/avatar-j.png","title" : "Lisa Hatchensen","desc" : "Msed quia non numquam eius","min":"one minutes ago" }] }';

$profileJson='{ "profileList":[{ "isModal" : "true", "dataTarget":".js-modal-profile","i18n" : "drpdwn.settings","title" : "View Profile" },{ "isDivider" : "true" },{"dataAction":"app-fullscreen","i18n" : "drpdwn.fullscreen","title" : "Fullscreen", "iClass" : "float-right text-muted fw-n", "iText" : "F11" },{"dataAction":"app-print","i18n" : "drpdwn.print","title" : "Print", "iClass" : "float-right text-muted fw-n", "iText" : "Ctrl + P" }] }';
 ?>
<!-- BEGIN Page Header -->
<header class="page-header" role="banner">
    <!-- we need this logo when user switches to nav-function-top -->
    <div class="page-logo">
        <a href="#" class="page-logo-link press-scale-down d-flex align-items-center position-relative" data-toggle="modal" data-target="#modal-shortcut">
            <img src="{{ url('public/assets/img/ ') }}" alt="SmartAdmin Laravel" aria-roledescription="logo">
            <span class="mr-1 page-logo-text">SmartAdmin Laravel</span>
            <span class="mr-2 text-white opacity-50 position-absolute small pos-top pos-right mt-n2"></span>
            <i class="ml-1 fal fa-angle-down d-inline-block fs-lg color-primary-300"></i>
        </a>
    </div>
    <!-- DOC: nav menu layout change shortcut -->
    <div class="hidden-md-down dropdown-icon-menu position-relative">
        <a href="#" class="header-btn btn js-waves-off" data-action="toggle" data-class="nav-function-hidden" title="Hide Navigation">
            <i class="ni ni-menu"></i>
        </a>
        <ul>
            <li>
                <a href="#" class="btn js-waves-off" data-action="toggle" data-class="nav-function-minify" title="Minify Navigation">
                    <i class="ni ni-minify-nav"></i>
                </a>
            </li>
            <li>
                <a href="#" class="btn js-waves-off" data-action="toggle" data-class="nav-function-fixed" title="Lock Navigation">
                    <i class="ni ni-lock-nav"></i>
                </a>
            </li>
        </ul>
    </div>
    <!-- DOC: mobile button appears during mobile width -->
    {{-- <div class="hidden-lg-up">
        <a href="#" class="header-btn btn press-scale-down" data-action="toggle" data-class="mobile-nav-on">
            <i class="ni ni-menu"></i>
        </a>
    </div>
    <div class="search">
        <form class="app-forms hidden-xs-down" role="search" action="/#" autocomplete="off">
            <input type="text" id="search-field" placeholder="Search for anything" class="form-control" tabindex="1">
            <a href="#" onclick="return false;" class="btn-danger btn-search-close js-waves-off d-none" data-action="toggle" data-class="mobile-search-on">
                <i class="fal fa-times"></i>
            </a>
        </form>
    </div> --}}
    <div class="ml-auto d-flex">
        <!-- activate app search icon (mobile) -->
        <div class="hidden-sm-up">
            <a href="#" class="header-icon" data-action="toggle" data-class="mobile-search-on" data-focus="search-field" title="Search">
                <i class="fal fa-search"></i>
            </a>
        </div>
        <!-- app settings -->
        {{-- <div class="hidden-md-down">
            <a href="#" class="header-icon" data-toggle="modal" data-target=".js-modal-settings">
                <i class="fal fa-cog"></i>
            </a>
        </div> --}}
        <!-- app message -->
        {{-- <a href="#" class="header-icon" data-toggle="modal" data-target=".js-modal-messenger">
            <i class="fal fa-globe"></i>
            <span class="badge badge-icon">!</span>
        </a> --}}
        <!-- app notification -->
        {{-- <div>
            <a href="#" class="header-icon" data-toggle="dropdown" title="You got 11 notifications">
                <i class="fal fa-bell"></i>
                <span class="badge badge-icon">11</span>
            </a>
            <div class="dropdown-menu dropdown-menu-animated dropdown-xl">
                <div class="mb-2 dropdown-header bg-trans-gradient d-flex justify-content-center align-items-center rounded-top">
                    <h4 class="m-0 text-center color-white">
                        11 New
                        <small class="mb-0 opacity-80">User Notifications</small>
                    </h4>
                </div>
                <ul class="nav nav-tabs nav-tabs-clean" role="tablist">
                    <li class="nav-item">
                        <a class="px-4 nav-link fs-md js-waves-on fw-500" data-toggle="tab" href="#tab-messages" data-i18n="drpdwn.messages">Messages</a>
                    </li>
                    <li class="nav-item">
                        <a class="px-4 nav-link fs-md js-waves-on fw-500" data-toggle="tab" href="#tab-feeds" data-i18n="drpdwn.feeds">Feeds</a>
                    </li>
                    <li class="nav-item">
                        <a class="px-4 nav-link fs-md js-waves-on fw-500" data-toggle="tab" href="#tab-events" data-i18n="drpdwn.events">Events</a>
                    </li>
                </ul>
                <div class="tab-content tab-notification">
                    <div class="p-3 text-center tab-pane active">
                        <h5 class="pt-4 mt-4 fw-500">
                            <span class="pb-4 d-block fa-3x text-muted">
                                <i class="ni ni-arrow-up text-gradient opacity-70"></i>
                            </span> Select a tab above to activate
                            <small class="mt-3 fs-b fw-400 text-muted">
                                This blank page message helps protect your privacy, or you can show the first message here automatically through
                                <a href="#">settings page</a>
                            </small>
                        </h5>
                    </div>
                    <div class="tab-pane" id="tab-messages" role="tabpanel">
                        <div class="custom-scroll h-100">
                            <ul class="notification">
                                <li class="unread">
                                    <a href="#" class="d-flex align-items-center">
                                        <span class="mr-2 status">
                                            <span class="profile-image rounded-circle d-inline-block" style="background-image:url('/img/demo/avatars/avatar-c.png')"></span>
                                        </span>
                                        <span class="flex-1 ml-1 d-flex flex-column">
                                            <span class="name">Melissa Ayre <span class="mt-1 badge badge-primary fw-n position-absolute pos-top pos-right">INBOX</span></span>
                                            <span class="msg-a fs-sm">Re: New security codes</span>
                                            <span class="msg-b fs-xs">Hello again and thanks for being part...</span>
                                            <span class="mt-1 fs-nano text-muted">56 seconds ago</span>
                                        </span>
                                    </a>
                                </li>
                                <?php

                                $decodedMenu1 = json_decode($notificationMenuJson);
                                ?>
                                @foreach ($decodedMenu1->{'notificationJson'} as $key => $value)
                                <li>
                                    <a href="#" class="d-flex align-items-center">
                                        <span class="mr-2 status status-danger">
                                            <span class="profile-image rounded-circle d-inline-block" style="background-image:url('{{ $value->avatar  }}')"></span>
                                        </span>
                                        <span class="flex-1 ml-1 d-flex flex-column">
                                            <span class="name">{{ $value->title }}</span>
                                            <span class="msg-a fs-sm">{{ $value->desc }}</span>
                                            <span class="mt-1 fs-nano text-muted">{{ $value->min }}</span>
                                        </span>
                                    </a>
                                </li>
                                @endforeach



                            </ul>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab-feeds" role="tabpanel">
                        <div class="custom-scroll h-100">
                            <ul class="notification">
                                <li class="unread">
                                    <div class="d-flex align-items-center show-child-on-hover">
                                        <span class="flex-1 d-flex flex-column">
                                            <span class="name d-flex align-items-center">Administrator <span class="ml-1 badge badge-success fw-n">UPDATE</span></span>
                                            <span class="msg-a fs-sm">
                                                System updated to version <strong>4.5.1</strong> <a href="#">(patch notes)</a>
                                            </span>
                                            <span class="mt-1 fs-nano text-muted">5 mins ago</span>
                                        </span>
                                        <div class="p-3 show-on-hover-parent position-absolute pos-right pos-bottom">
                                            <a href="#" class="text-muted" title="delete"><i class="fal fa-trash-alt"></i></a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex align-items-center show-child-on-hover">
                                        <div class="flex-1 d-flex flex-column">
                                            <span class="name">
                                                Adison Lee <span class="fw-300 d-inline">replied to your video <a href="#" class="fw-400"> Cancer Drug</a> </span>
                                            </span>
                                            <span class="mt-2 msg-a fs-sm">Bring to the table win-win survival strategies to ensure proactive domination. At the end of the day...</span>
                                            <span class="mt-1 fs-nano text-muted">10 minutes ago</span>
                                        </div>
                                        <div class="p-3 show-on-hover-parent position-absolute pos-right pos-bottom">
                                            <a href="#" class="text-muted" title="delete"><i class="fal fa-trash-alt"></i></a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex align-items-center show-child-on-hover">
                                        <!--<img src="img/demo/avatars/avatar-m.png" data-src="img/demo/avatars/avatar-k.png" class="profile-image rounded-circle" alt="k" />-->
                                        <div class="flex-1 d-flex flex-column">
                                            <span class="name">
                                                Troy Norman'<span class="fw-300">s new connections</span>
                                            </span>
                                            <div class="mt-2 fs-sm d-flex align-items-center">
                                                <span class="mr-1 profile-image-md rounded-circle d-inline-block" style="background-image:url('/img/demo/avatars/avatar-a.png'); background-size: cover;"></span>
                                                <span class="mr-1 profile-image-md rounded-circle d-inline-block" style="background-image:url('/img/demo/avatars/avatar-b.png'); background-size: cover;"></span>
                                                <span class="mr-1 profile-image-md rounded-circle d-inline-block" style="background-image:url('/img/demo/avatars/avatar-c.png'); background-size: cover;"></span>
                                                <span class="mr-1 profile-image-md rounded-circle d-inline-block" style="background-image:url('/img/demo/avatars/avatar-e.png'); background-size: cover;"></span>
                                                <div data-hasmore="+3" class="mr-1 rounded-circle profile-image-md">
                                                    <span class="mr-1 profile-image-md rounded-circle d-inline-block" style="background-image:url('/img/demo/avatars/avatar-h.png'); background-size: cover;"></span>
                                                </div>
                                            </div>
                                            <span class="mt-1 fs-nano text-muted">55 minutes ago</span>
                                        </div>
                                        <div class="p-3 show-on-hover-parent position-absolute pos-right pos-bottom">
                                            <a href="#" class="text-muted" title="delete"><i class="fal fa-trash-alt"></i></a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex align-items-center show-child-on-hover">
                                        <!--<img src="img/demo/avatars/avatar-m.png" data-src="img/demo/avatars/avatar-e.png" class="mt-1 profile-image-sm rounded-circle align-self-start" alt="k" />-->
                                        <div class="flex-1 d-flex flex-column">
                                            <span class="name">Dr John Cook <span class="fw-300">sent a <span class="text-danger">new signal</span></span></span>
                                            <span class="mt-2 msg-a fs-sm">Nanotechnology immersion along the information highway will close the loop on focusing solely on the bottom line.</span>
                                            <span class="mt-1 fs-nano text-muted">10 minutes ago</span>
                                        </div>
                                        <div class="p-3 show-on-hover-parent position-absolute pos-right pos-bottom">
                                            <a href="#" class="text-muted" title="delete"><i class="fal fa-trash-alt"></i></a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex align-items-center show-child-on-hover">
                                        <div class="flex-1 d-flex flex-column">
                                            <span class="name">Lab Images <span class="fw-300">were updated!</span></span>
                                            <div class="mt-1 fs-sm d-flex align-items-center">
                                                <a href="#" class="mt-1 mr-1" title="Cell A-0012">
                                                    <span class="d-block img-share" style="background-image:url('/img/thumbs/pic-7.png'); background-size: cover;"></span>
                                                </a>
                                                <a href="#" class="mt-1 mr-1" title="Patient A-473 saliva">
                                                    <span class="d-block img-share" style="background-image:url('/img/thumbs/pic-8.png'); background-size: cover;"></span>
                                                </a>
                                                <a href="#" class="mt-1 mr-1" title="Patient A-473 blood cells">
                                                    <span class="d-block img-share" style="background-image:url('/img/thumbs/pic-11.png'); background-size: cover;"></span>
                                                </a>
                                                <a href="#" class="mt-1 mr-1" title="Patient A-473 Membrane O.C">
                                                    <span class="d-block img-share" style="background-image:url('/img/thumbs/pic-12.png'); background-size: cover;"></span>
                                                </a>
                                            </div>
                                            <span class="mt-1 fs-nano text-muted">55 minutes ago</span>
                                        </div>
                                        <div class="p-3 show-on-hover-parent position-absolute pos-right pos-bottom">
                                            <a href="#" class="text-muted" title="delete"><i class="fal fa-trash-alt"></i></a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex align-items-center show-child-on-hover">
                                        <!--<img src="img/demo/avatars/avatar-m.png" data-src="img/demo/avatars/avatar-h.png" class="mt-1 profile-image rounded-circle align-self-start" alt="k" />-->
                                        <div class="flex-1 d-flex flex-column">
                                            <div class="mb-2 name">
                                                Lisa Lamar<span class="fw-300"> updated project</span>
                                            </div>
                                            <div class="row fs-b fw-300">
                                                <div class="text-left col">
                                                    Progress
                                                </div>
                                                <div class="text-right col fw-500">
                                                    45%
                                                </div>
                                            </div>
                                            <div class="mt-1 progress progress-sm d-flex">
                                                <span class="progress-bar bg-primary-500 progress-bar-striped" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100"></span>
                                            </div>
                                            <span class="mt-1 fs-nano text-muted">2 hrs ago</span>
                                            <div class="p-3 show-on-hover-parent position-absolute pos-right pos-bottom">
                                                <a href="#" class="text-muted" title="delete"><i class="fal fa-trash-alt"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-pane" id="tab-events" role="tabpanel">
                        <div class="d-flex flex-column h-100">
                            <div class="h-auto">
                                <table class="table m-0 border-0 table-bordered table-calendar w-100 h-100">
                                    <tr>
                                        <th colspan="7" class="pt-3 pb-2 pl-3 pr-3 text-center">
                                            <div class="mb-2 js-get-date h5">[your date here]</div>
                                        </th>
                                    </tr>
                                    <tr class="text-center">
                                        <th>Sun</th>
                                        <th>Mon</th>
                                        <th>Tue</th>
                                        <th>Wed</th>
                                        <th>Thu</th>
                                        <th>Fri</th>
                                        <th>Sat</th>
                                    </tr>
                                    <tr>
                                        <td class="text-muted bg-faded">30</td>
                                        <td>1</td>
                                        <td>2</td>
                                        <td>3</td>
                                        <td>4</td>
                                        <td>5</td>
                                        <td><i class="mt-1 ml-1 fal fa-birthday-cake position-absolute pos-left pos-top text-primary"></i> 6</td>
                                    </tr>
                                    <tr>
                                        <td>7</td>
                                        <td>8</td>
                                        <td>9</td>
                                        <td class="bg-primary-300 pattern-0">10</td>
                                        <td>11</td>
                                        <td>12</td>
                                        <td>13</td>
                                    </tr>
                                    <tr>
                                        <td>14</td>
                                        <td>15</td>
                                        <td>16</td>
                                        <td>17</td>
                                        <td>18</td>
                                        <td>19</td>
                                        <td>20</td>
                                    </tr>
                                    <tr>
                                        <td>21</td>
                                        <td>22</td>
                                        <td>23</td>
                                        <td>24</td>
                                        <td>25</td>
                                        <td>26</td>
                                        <td>27</td>
                                    </tr>
                                    <tr>
                                        <td>28</td>
                                        <td>29</td>
                                        <td>30</td>
                                        <td>31</td>
                                        <td class="text-muted bg-faded">1</td>
                                        <td class="text-muted bg-faded">2</td>
                                        <td class="text-muted bg-faded">3</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="flex-1 custom-scroll">
                                <div class="p-2">
                                    <div class="mb-3 text-left d-flex align-items-center">
                                        <div class="mr-1 width-5 fw-300 text-primary l-h-n align-self-start fs-xxl">
                                            15
                                        </div>
                                        <div class="flex-1">
                                            <div class="d-flex flex-column">
                                                <span class="l-h-n fs-md fw-500 opacity-70">
                                                    October 2020
                                                </span>
                                                <span class="l-h-n fs-nano fw-400 text-secondary">
                                                    Friday
                                                </span>
                                            </div>
                                            <div class="mt-3">
                                                <p>
                                                    <strong>2:30PM</strong> - Doctor's appointment
                                                </p>
                                                <p>
                                                    <strong>3:30PM</strong> - Report overview
                                                </p>
                                                <p>
                                                    <strong>4:30PM</strong> - Meeting with Donnah V.
                                                </p>
                                                <p>
                                                    <strong>5:30PM</strong> - Late Lunch
                                                </p>
                                                <p>
                                                    <strong>6:30PM</strong> - Report Compression
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-3 py-2 text-right bg-faded d-block rounded-bottom border-faded border-bottom-0 border-right-0 border-left-0">
                    <a href="#" class="ml-auto fs-xs fw-500">view all notifications</a>
                </div>
            </div>
        </div> --}}
        <!-- app user menu -->
        <div>
            @if(isset(Auth::user()->profile_image))
                <a href="#" data-toggle="dropdown" title="drlantern@gotbootstrap.com" class="ml-2 header-icon d-flex align-items-center justify-content-center">
                    <img src="{{ asset('storage/userprofile/' . Auth::user()->profile_image) }}" class="profile-image rounded-circle" alt="Dr. Codex Lantern" style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">
                </a>
            @else
                <a href="#" data-toggle="dropdown" title="drlantern@gotbootstrap.com" class="ml-2 header-icon d-flex align-items-center justify-content-center">
                    <img src="{{ url('public/assets/img/profileicon.jpg') }}" class="profile-image rounded-circle" alt="Dr. Codex Lantern" style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">
                </a>
            @endif
            <div class="dropdown-menu dropdown-menu-animated dropdown-lg">
                <div class="flex-row py-4 dropdown-header bg-trans-gradient d-flex rounded-top">
                    <div class="flex-row mt-1 mb-1 d-flex align-items-center color-white">
                        <span class="mr-2">
                            @if(isset(Auth::user()->profile_image))
                                <img src="{{ asset('storage/userprofile/' . Auth::user()->profile_image) }}" class="profile-image rounded-circle" alt="Dr. Codex Lantern" style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">
                            @else
                                <img src="{{ url('public/assets/img/profileicon.jpg') }}" class="profile-image rounded-circle" alt="Dr. Codex Lantern" style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%;">
                            @endif
                       </span>
                        <div class="info-card-text">
                            <div class="fs-lg text-truncate text-truncate-lg">
                                {{ ucfirst(auth()->user()->name) }}
                            </div>
                            <span class="text-truncate text-truncate-md opacity-80">{{auth()->user()->email}}</span>
                        </div>
                    </div>
                </div>
                <div class="m-0 dropdown-divider"></div>
                <?php $decodedProfile = json_decode($profileJson); ?>

                @foreach ($decodedProfile->{'profileList'} as $key => $value)
                @if(isset($value->isModal) && ($value->isModal === "true"))
                <a href="#" class="dropdown-item" data-toggle="modal" data-target="{{ $value->dataTarget }}">
                    <span data-i18n="{{ $value->i18n }}">{{ $value->title }}</span>
                </a>
                @elseif(isset($value->isDivider) && ($value->isDivider === "true"))
                <div class="m-0 dropdown-divider"></div>
                @else
                <a href="#" class="dropdown-item" data-action="{{ $value->dataAction }}">
                    <span data-i18n="{{ $value->i18n }}">{{ $value->title }}</span>
                    @if(isset($value->iClass))
                    <i class="{{ $value->iClass }}">{{ $value->iText }}</i>
                    @endif
                </a>
                @endif
                @endforeach
                {{-- <div class="dropdown-multilevel dropdown-multilevel-left">
                    <div class="dropdown-item">
                        Language
                    </div>
                    <div class="dropdown-menu">
                        <a href="#?lang=fr" class="dropdown-item" data-action="lang" data-lang="fr">Français</a>
                        <a href="#?lang=en" class="dropdown-item active" data-action="lang" data-lang="en">English (US)</a>
                        <a href="#?lang=es" class="dropdown-item" data-action="lang" data-lang="es">Español</a>
                        <a href="#?lang=ru" class="dropdown-item" data-action="lang" data-lang="ru">Русский язык</a>
                        <a href="#?lang=jp" class="dropdown-item" data-action="lang" data-lang="jp">日本語</a>
                        <a href="#?lang=ch" class="dropdown-item" data-action="lang" data-lang="ch">中文</a>
                    </div>
                </div> --}}
                <div class="m-0 dropdown-divider"></div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>

                <a class="pt-3 pb-3 dropdown-item fw-500" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <span data-i18n="drpdwn.page-logout">Logout</span>
                    {{-- <span class="float-right fw-n">&commat;codexlantern</span> --}}
                </a>
            </div>
        </div>
    </div>
</header>
<!-- END Page Header -->
