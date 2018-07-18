<form id="mentor-request" action="" class="prevent-default" method="post">
    {{ csrf_field() }}
    <input id="mentor_id" name="mentor_id" type="hidden" value="" />
    <div class="row">
        <div class="col s12">
            <p>Please select three dates and times that work for you and we'll do our best to match you up with <span class="mentor-name"></span>.</p>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s6">
            <input id="date_1" class="datepicker" name="date_1" type="text" value="" placeholder="First option" />
        </div>
        <div class="input-field col s6">
            <select id="time_1" name="time_1" class="browser-default">
                <option value="0900">9:00 AM (PST)</option>
                <option value="0930">9:30 AM (PST)</option>
                <option value="1000">10:00 AM (PST)</option>
                <option value="1030">10:30 AM (PST)</option>
                <option value="1100">11:00 AM (PST)</option>
                <option value="1130">11:30 AM (PST)</option>
                <option value="1200">12:00 AM (PST)</option>
                <option value="1230">12:30 AM (PST)</option>
                <option value="1300">1:00 PM (PST)</option>
                <option value="1330">1:30 PM (PST)</option>
                <option value="1400">2:00 PM (PST)</option>
                <option value="1430">2:30 PM (PST)</option>
                <option value="1500">3:00 PM (PST)</option>
                <option value="1530">3:30 PM (PST)</option>
                <option value="1600">4:00 PM (PST)</option>
                <option value="1630">4:30 PM (PST)</option>
                <option value="1700">5:00 PM (PST)</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s6">
            <input id="date_2" class="datepicker" name="date_2" type="text" value="" placeholder="Second option" />
        </div>
        <div class="input-field col s6">
            <select id="time_2" name="time_2" class="browser-default">
                <option value="0900">9:00 AM (PST)</option>
                <option value="0930">9:30 AM (PST)</option>
                <option value="1000">10:00 AM (PST)</option>
                <option value="1030">10:30 AM (PST)</option>
                <option value="1100">11:00 AM (PST)</option>
                <option value="1130">11:30 AM (PST)</option>
                <option value="1200">12:00 AM (PST)</option>
                <option value="1230">12:30 AM (PST)</option>
                <option value="1300">1:00 PM (PST)</option>
                <option value="1330">1:30 PM (PST)</option>
                <option value="1400">2:00 PM (PST)</option>
                <option value="1430">2:30 PM (PST)</option>
                <option value="1500">3:00 PM (PST)</option>
                <option value="1530">3:30 PM (PST)</option>
                <option value="1600">4:00 PM (PST)</option>
                <option value="1630">4:30 PM (PST)</option>
                <option value="1700">5:00 PM (PST)</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="input-field col s6">
            <input id="date_3" class="datepicker" name="date_3" type="text" value="" placeholder="Third option" />
        </div>
        <div class="input-field col s6">
            <select id="time_3" name="time_3" class="browser-default">
                <option value="0900">9:00 AM (PST)</option>
                <option value="0930">9:30 AM (PST)</option>
                <option value="1000">10:00 AM (PST)</option>
                <option value="1030">10:30 AM (PST)</option>
                <option value="1100">11:00 AM (PST)</option>
                <option value="1130">11:30 AM (PST)</option>
                <option value="1200">12:00 AM (PST)</option>
                <option value="1230">12:30 AM (PST)</option>
                <option value="1300">1:00 PM (PST)</option>
                <option value="1330">1:30 PM (PST)</option>
                <option value="1400">2:00 PM (PST)</option>
                <option value="1430">2:30 PM (PST)</option>
                <option value="1500">3:00 PM (PST)</option>
                <option value="1530">3:30 PM (PST)</option>
                <option value="1600">4:00 PM (PST)</option>
                <option value="1630">4:30 PM (PST)</option>
                <option value="1700">5:00 PM (PST)</option>
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
