<template>
  <div>
    <div class="vue-timetable vue-timetable-week-mode" data-view="week" id="timetable-3">
      <div class="vue-timetable-hours">
        <div class="vue-timetable-hour" v-for="(i, index) in (date.hours.end - (date.hours.start -1))" :key="'duration-' + index" :style="{ height: height + 'px' }">
          <span>{{ i + (date.hours.start - 1) }}:00</span>
        </div>
      </div>
      <div class="vue-timetable-content">
        <div class="vue-timetable-columns">
          <div class="vue-timetable-column" v-for="(day, index) in date.list" :key="'day-' + index">
            <slot name="header" :day="day">
              <div class="vue-timetable-column-header">
                {{ day.date | moment("dddd") }}<br>
                <!-- <span>{{ day.date | moment("DD/MM/YYYY") }}</span> -->
              </div>
            </slot>
            <div class="vue-timetable-column-content">
              <span class="vue-timetable-event" v-for="(event, index) in day.events" :key="'event-' + index" :style="{ top: event.placement.top + 'px', height: event.placement.height + 'px', backgroundColor: event.color }">
                <slot :event="event">
                  <span>{{ event.text }}</span>
                </slot>
              </span>
            </div>
            <div class="vue-timetable-column-grid">
              <div :style="{ height: (height - 1) + 'px'}" class="vue-timetable-grid-item" v-for="(i, index) in (date.hours.end - date.hours.start)" :key="'date-duration-' + index"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div style="clear: both"></div>
  </div>
</template>

<script>
  import moment from 'moment'
  export default {
    name: 'week-timetable',
    props: ['week', 'events', 'hour-range', 'day-range', 'cell-height'],
    data () {
      return {
        height: this.cellHeight ? this.cellHeight : 50,
        date: {
          week: this.week ? moment(this.week) : moment().weekday(0),
          hours: this.hourRange ? this.hourRange : {start: 6, end: 24},
          days: this.dayRange ? this.dayRange : [1, 2, 3, 4, 5, 6, 7],
          list: []
        }
      }
    },
    mounted () {
    },
    methods: {
      moment () {
        return moment()
      },
      fillDaysList () {
        this.date.list = []
        let now = this.date.week.clone()
        while (now.week() === this.date.week.week()) {
          if (this.date.days.indexOf(now.isoWeekday()) !== -1) {
            this.date.list.push({
              date: now.format(),
              events: this.getDayEvents(now)
            })
            console.log("LIST: ",this.date.list)
          }
          now.add(1, 'days')
        }
      },
      
      getDayEvents (day) {
        let self = this
        if (typeof this.events === 'undefined') {
          return []
        }
        return this.events.map(event => {
          event.placement = {
            top: ((event.date.from.hour() * 60 + event.date.from.minute()) - self.date.hours.start * 60) / 60 * self.height,
            height: Math.round(event.date.to.diff(event.date.from, 'minutes') / 60 * self.height)
          }
          return event
        }).filter((event) => {
          return day.isSame(event.date.from, 'day') && event.placement.top >= 0
        }).sort((a, b) => {
          return moment(b.date.from).isBefore(a.date.from)
        })
      }
    },
    watch: {
      events () {
        // Fill the days events if the events data changes
        this.fillDaysList()
      },
      week (week) {
        this.date.week = moment(week)
        this.fillDaysList()
      }
    },
    created () {
      // Fill the days events on the component creation
      setTimeout(() => {
        this.fillDaysList()
      }, 1000);
    }
  }
</script>
<style lang="css">
  /* Timetable */
.vue-timetable * {
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  -webkit-box-sizing: border-box;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
}
.vue-timetable {
  width: 100%;
  float: left;
}

/********** Vue timetable : week-mode **********/
.vue-timetable.vue-timetable-week-mode {
  display: table;
  width: 100%;
}
.vue-timetable.vue-timetable-week-mode .vue-timetable-hours {
  display: table-cell;
  width: 60px;
  padding-top: 60px;
  vertical-align: top;
}
.vue-timetable.vue-timetable-week-mode .vue-timetable-hours .vue-timetable-hour {
  height: 50px;
  position: relative;
}
.vue-timetable.vue-timetable-week-mode .vue-timetable-hours .vue-timetable-hour span {
  display: inline-block;
  width: 100%;
  height: 20px;
  font-size: 15px;
  position: absolute;
  top: -20px;
  right: 0;
  border-bottom: 1px solid #e8e8e8;
}
.vue-timetable.vue-timetable-week-mode .vue-timetable-content {
  display: table-cell;
}
.vue-timetable.vue-timetable-week-mode .vue-timetable-content .vue-timetable-columns {
  display: table;
  width: 100%;
  table-layout: fixed;
  vertical-align: top;
}
.vue-timetable.vue-timetable-week-mode .vue-timetable-content .vue-timetable-columns .vue-timetable-column {
  display: table-cell;
  position: relative;
}
.vue-timetable.vue-timetable-week-mode .vue-timetable-content .vue-timetable-columns .vue-timetable-column .vue-timetable-column-header {
  height: 60px;
  padding: 11px 0;
  background-color: #64b0f2;
  color: #ffffff;
  text-align: center;
  border-right: 1px solid #d1d1d1;
  overflow: hidden;
}
.vue-timetable.vue-timetable-week-mode .vue-timetable-content .vue-timetable-columns .vue-timetable-column:last-child .vue-timetable-column-header {
  border-right: none;
}
.vue-timetable.vue-timetable-week-mode .vue-timetable-content .vue-timetable-columns .vue-timetable-column .vue-timetable-column-header span {
  font-size: 14px;
  color: #ffffff;
}
.vue-timetable.vue-timetable-week-mode .vue-timetable-content .vue-timetable-columns .vue-timetable-column .vue-timetable-column-content {
  position: absolute;
  top: 60px;
  width: 100%;
}
.vue-timetable.vue-timetable-week-mode .vue-timetable-content .vue-timetable-columns .vue-timetable-column .vue-timetable-column-content .vue-timetable-event {
  color: #ffffff;
  vertical-align: middle;
  position: absolute;
  top: 0;
  left: 0;
  width: calc(100% - 1px);
  height: 49px;
  text-decoration: none;
  outline: none;
}
.vue-timetable.vue-timetable-week-mode .vue-timetable-content .vue-timetable-columns .vue-timetable-column .vue-timetable-column-content .vue-timetable-event:hover {
  opacity: 0.8;
}
.vue-timetable.vue-timetable-week-mode .vue-timetable-content .vue-timetable-columns .vue-timetable-column .vue-timetable-column-content .vue-timetable-event > span {
  display: table;
  color: inherit;
  position: absolute;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
  margin: auto;
  text-align: center;
  vertical-align: middle;
  width: 100%;
  font-size: 15px;
  padding: 5px 10px;
}
.vue-timetable.vue-timetable-week-mode .vue-timetable-content .vue-timetable-columns .vue-timetable-column .vue-timetable-column-grid .vue-timetable-grid-item {
  border-right: 1px solid #e8e8e8;
  border-bottom: 1px solid #e8e8e8;
  height: 50px;
  -webkit-box-sizing: content-box;
  -moz-box-sizing: content-box;
  box-sizing: content-box;
}
.vue-timetable.vue-timetable-week-mode .vue-timetable-content .vue-timetable-columns .vue-timetable-column:first-child .vue-timetable-column-grid .vue-timetable-grid-item {
  border-left: 1px solid #e8e8e8;
}
.vue-timetable.vue-timetable-week-mode .vue-timetable-content .vue-timetable-columns .vue-timetable-column:last-child .vue-timetable-column-grid .vue-timetable-grid-item {
  border-right: 1px solid #e8e8e8;
}

/********** Vue timetable : list-mode **********/
.vue-timetable.vue-timetable-list-mode {
  width: 100%;
}
.vue-timetable.vue-timetable-list-mode header {
  text-align: left;
  background-color: #64b0f2;
  color: #ffffff;
  height: 36px;
  line-height: 36px;
  padding: 0 15px;
}
.vue-timetable.vue-timetable-list-mode header span {
  float: right;
  font-size: 15px;
  color: #ffffff;
}
.vue-timetable.vue-timetable-list-mode .vue-timetable-day-container:last-child {
  border-bottom: 1px solid #d1d1d1;
}
.vue-timetable.vue-timetable-list-mode ul {
  margin: 0;
  padding: 15px;
  border-left: 1px solid #d1d1d1;
  border-right: 1px solid #d1d1d1;
  list-style-type: none;
}
.vue-timetable.vue-timetable-list-mode ul li {
  position: relative;
  text-align: left;
  margin-bottom: 8px;
  padding-left: 8px;
}
.vue-timetable.vue-timetable-list-mode ul li:last-child {
  margin-bottom: 6px;
}
.vue-timetable.vue-timetable-list-mode ul li .vue-timetable-event-color {
  position: absolute;
  top: 1px;
  left: 0;
  width: 2px;
  height: 100%;
  -webkit-border-radius: 20px;
  -moz-border-radius: 20px;
  border-radius: 20px;
  -webkit-transition: all 0.2s;
  -o-transition: all 0.2s;
  transition: all 0.2s;
}
.vue-timetable.vue-timetable-list-mode ul li .vue-timetable-event-link {
  font-size: 15px;
  line-height: initial;
  text-decoration: none;
  outline: none;
}
.vue-timetable.vue-timetable-list-mode ul li .vue-timetable-event-time {
  margin-right: 7px;
}


/********** Vue timetable : month-mode **********/
.vue-timetable.vue-timetable-month-mode {
  width: 100%;
  border-collapse: collapse;
  border-spacing: 0;
  color: #ffffff;
  table-layout: fixed;
}
.vue-timetable.vue-timetable-month-mode,
.vue-timetable.vue-timetable-month-mode th,
.vue-timetable.vue-timetable-month-mode td {
  border: 1px solid #d1d1d1;
}
.vue-timetable.vue-timetable-month-mode thead th {
  padding: 12px 0;
  background-color: #64b0f2;
  font-weight: 400;
  text-align: center;
  color: #ffffff;
  text-transform: capitalize;
  overflow: hidden;
}

.vue-timetable.vue-timetable-month-mode td {
  position: relative;
  color: #ababab;
  font-size: 14px;
  text-align: left;
  vertical-align: top;
  padding: 24px 10px 5px 10px;
  height: 60px;
  line-height: 20px;
}
.vue-timetable.vue-timetable-month-mode td.today {
  padding: 24px 10px 5px 10px;
}
.vue-timetable.vue-timetable-month-mode .vue-timetable-day {
  position: absolute;
  top: 2px;
  right: 6px;
}
.vue-timetable.vue-timetable-month-mode .vue-timetable-now .vue-timetable-day {
  background: #64b0f2;
  color: #ffffff;
  top: 0;
  right: 0;
  padding: 2px 6px;
  display: inline-block;
}
.vue-timetable.vue-timetable-month-mode .vue-timetable-event {
  margin-bottom: 7px;
  position: relative;
  padding-left: 7px;
}
.vue-timetable.vue-timetable-month-mode .vue-timetable-event * {
  font-size: 14px;
}
.vue-timetable.vue-timetable-month-mode .vue-timetable-event .vue-timetable-event-color {
  position: absolute;
  top: 0;
  left: 0;
  margin: auto;
  width: 2px;
  height: 100%;
  -webkit-transition: all 0.2s;
  -o-transition: all 0.2s;
  transition: all 0.2s;
}
.vue-timetable.vue-timetable-month-mode .vue-timetable-event .vue-timetable-event-link {
  font-size: 13px;
  text-decoration: none;
  outline: none;
  display: block;
  line-height: 18px;
}
.vue-timetable.vue-timetable-month-mode .vue-timetable-event .vue-timetable-event-time {
  font-weight: bold;
  margin-right: 5px;
  color: #535353;
}
.vue-timetable.vue-timetable-month-mode .vue-timetable-event .vue-timetable-event-name {
  color: #535353;
}


@media screen and (max-width: 768px) {
  /********** Vue timetable : month-mode **********/
  .vue-timetable.vue-timetable-month-mode td {
    padding-left: 3px;
    padding-right: 3px;
  }
  .vue-timetable.vue-timetable-month-mode .vue-timetable-day {
    font-size: 14px;
  }
  .vue-timetable.vue-timetable-month-mode .vue-timetable-event * {
    font-size: 12px;
  }
  .vue-timetable.vue-timetable-month-mode .vue-timetable-event {
    margin-bottom: 9px;
    padding-left: 5px;
  }
  .vue-timetable.vue-timetable-month-mode .vue-timetable-event .vue-timetable-event-link {
    line-height: 16px;
  }

  /********** Vue timetable : week-mode **********/
  .vue-timetable.vue-timetable-week-mode .vue-timetable-hours {
    width: 50px;
  }
  .vue-timetable.vue-timetable-week-mode .vue-timetable-content .vue-timetable-columns .vue-timetable-column .vue-timetable-column-content .vue-timetable-event > span {
    padding: 0;
    font-size: 14px;
  }
  .vue-timetable.vue-timetable-week-mode .vue-timetable-hours .vue-timetable-hour span,
  .vue-timetable.vue-timetable-week-mode .vue-timetable-column-header {
    font-size: 13px;
  }
  .vue-timetable.vue-timetable-week-mode .vue-timetable-content .vue-timetable-columns .vue-timetable-column .vue-timetable-column-header span {
    font-size: 12px;
  }
}
@media screen and (max-width: 580px) {
  /********** Vue timetable : month-mode **********/
  .vue-timetable.vue-timetable-month-mode thead th {
    font-size: 14px;
    padding-left: 1px;
  }
  .vue-timetable.vue-timetable-month-mode td {
    padding-left: 0px;
    padding-right: 2px;
  }
  .vue-timetable.vue-timetable-month-mode .vue-timetable-event .vue-timetable-event-name {
    display: none;
  }

  /********** Vue timetable : week-mode **********/
  .vue-timetable.vue-timetable-week-mode .vue-timetable-content .vue-timetable-columns .vue-timetable-column .vue-timetable-column-content .vue-timetable-event > span {
    padding: 0;
    font-size: 13px;
  }
}
</style>