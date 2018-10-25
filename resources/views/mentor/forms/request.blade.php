<form id="mentor-request" action="" class="prevent-default" method="post">
    {{ csrf_field() }}
    <input id="mentor_id" name="mentor_id" type="hidden" value="" />
    <div class="row">
        <div class="col m4 mentor-img center-align">
           <p style="text-align: center;"><strong><span class="mentor-name"></span></strong></p>
        </div>
        <div class="col m8">
            <p style="font-size: 18px; margin: 0px; line-height: 1;">Please select three dates and times that work for you and your mentor.</p>
            <p style="marign: 0px; line-height: 1;"><strong><span class="mentor-name"></span>'s</strong> pefered times (<span class="mentor-timezone"></span>):</p>
            <ul class="">
                <li><span class="mentor-day-preference-1"></span> - <span class="mentor-time-preference-1"></span></li>
                <li><span class="mentor-day-preference-2"></span> - <span class="mentor-time-preference-2"></span></li>
                <li><span class="mentor-day-preference-3"></span> - <span class="mentor-time-preference-3"></span></li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s6" style="margin-top: 0;">
            <input id="date_1" style="margin-bottom: 0;" class="datepicker" name="date_1" type="text" value="" placeholder="First option" />
        </div>
        <div class="input-field col s6" style="margin-top: 0;">
            <select id="time_1" name="time_1" class="browser-default">
                <option value="0900">9:00 AM</option>
                <option value="0930">9:30 AM</option>
                <option value="1000">10:00 AM</option>
                <option value="1030">10:30 AM</option>
                <option value="1100">11:00 AM</option>
                <option value="1130">11:30 AM</option>
                <option value="1200">12:00 AM</option>
                <option value="1230">12:30 AM</option>
                <option value="1300">1:00 PM</option>
                <option value="1330">1:30 PM</option>
                <option value="1400">2:00 PM</option>
                <option value="1430">2:30 PM</option>
                <option value="1500">3:00 PM</option>
                <option value="1530">3:30 PM</option>
                <option value="1600">4:00 PM</option>
                <option value="1630">4:30 PM</option>
                <option value="1700">5:00 PM</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s6" style="margin-top: 0;">
            <input id="date_2" style="margin-bottom: 0;" class="datepicker" name="date_2" type="text" value="" placeholder="Second option" />
        </div>
        <div class="input-field col s6" style="margin-top: 0;">
            <select id="time_2" name="time_2" class="browser-default">
                <option value="0900">9:00 AM</option>
                <option value="0930">9:30 AM</option>
                <option value="1000">10:00 AM</option>
                <option value="1030">10:30 AM</option>
                <option value="1100">11:00 AM</option>
                <option value="1130">11:30 AM</option>
                <option value="1200">12:00 AM</option>
                <option value="1230">12:30 AM</option>
                <option value="1300">1:00 PM</option>
                <option value="1330">1:30 PM</option>
                <option value="1400">2:00 PM</option>
                <option value="1430">2:30 PM</option>
                <option value="1500">3:00 PM</option>
                <option value="1530">3:30 PM</option>
                <option value="1600">4:00 PM</option>
                <option value="1630">4:30 PM</option>
                <option value="1700">5:00 PM</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s6" style="margin-top: 0;">
            <input id="date_3" style="margin-bottom: 0;" class="datepicker" name="date_3" type="text" value="" placeholder="Third option" />
        </div>
        <div class="input-field col s6" style="margin-top: 0;">
            <select id="time_3" name="time_3" class="browser-default">
                <option value="0900">9:00 AM</option>
                <option value="0930">9:30 AM</option>
                <option value="1000">10:00 AM</option>
                <option value="1030">10:30 AM</option>
                <option value="1100">11:00 AM</option>
                <option value="1130">11:30 AM</option>
                <option value="1200">12:00 AM</option>
                <option value="1230">12:30 AM</option>
                <option value="1300">1:00 PM</option>
                <option value="1330">1:30 PM</option>
                <option value="1400">2:00 PM</option>
                <option value="1430">2:30 PM</option>
                <option value="1500">3:00 PM</option>
                <option value="1530">3:30 PM</option>
                <option value="1600">4:00 PM</option>
                <option value="1630">4:30 PM</option>
                <option value="1700">5:00 PM</option>
            </select>
        </div>
    </div>
    <div id="mentor-submit" class="row">
        <div class="input-field col s12 center-align">
            <button type="submit" class="btn sbs-red">Submit</button>
        </div>
    </div>
    <div id="mentor-progress" class="row hidden">
        <div class="input-field col s12">
            <div class="progress">
                <div class="indeterminate"></div>
            </div>
        </div>
    </div>
</form>
