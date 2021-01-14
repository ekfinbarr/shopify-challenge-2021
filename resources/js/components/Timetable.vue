<template>
	<div>
		<h2>Timetable Generator</h2>
		
		<div class="bar">
			<input type="text" placeholder="start" v-model="startTime" />
			<input type="text" placeholder="end" v-model="endTime" />
			<input type="text" placeholder="length" v-model="length" />

			<input type="number" placeholder="number" v-model="slots" />

			<select v-model="day">
				<option v-for="day in weekDays" :value="day">{{day}}</option>
			</select>
		</div>

		<button @click="generate">Generate</button>

		<ul v-for="day in weekDays">
			<h2>{{ day }}</h2>
			<li v-for="entry in list[day]">{{ entry.start + ' - ' + entry.end }}</li>
		</ul>
	</div>
</template>


<script>
	module.exports = {
		data() {
			return {
				weekDays: ['P','A','T','K','Pe','Š','S'],
				startTime: '9:00',
				endTime: '10:45',
				length: '15',
				slots: 1,
				day: 'T',
				list: {	
					"P":[],
					"A":[],
					"T":[],
					"K":[],
					"Pe":[],
					"Š":[],
					"S":[]
				}
			}
		},
		methods: {
			populateList() {
				this.list = {};
				for (day of this.weekDays) {
					this.list[day] = [];
					// testing - dummy data
					// this.list[day].append({
					// 	start: '9:00',
					// 	end: '10:00'
					// },
					// {
					// 	start: '8:00',
					// 	end: '10:80'
					// },
					// {
					// 	start: '7:00',
					// 	end: '15:00'
					// })
				}
			},
			generate () {
				// console.log('Calculating')
				let tmp = [], 
					slot = {}, 
					i = 0,
					list = this.list,
					day = this.day,
					cur = this.startTime,
					length = this.length,
					end = this.endTime,
					slots = this.slots;
        
        // Missing check for endTime...
				while (i < slots) {
					slot = {
						start: cur,
						end: this.addHours(length, cur)
					}
					tmp.push(slot);
					i++;
					cur = slot.end;
				}
				list[day] = tmp;
			},
			// Adds HH:mm to HH:mm
			// for ex. 11:00 + 1:55 = 12:55 | 23:45 + 30 = 00:15
			addHours (add, to) {
				// if add is minutes, make it as hours
				// 15 -> 00:15 and so on
				if (!/:/.test(add)) {
					add = '00:' + ('0' + add).slice(-2);
				}
				if (!/:/.test(to)) {
					to = '00:' + ('0' + to).slice(-2);
				}
				let addHour = parseInt(add.split(':')[0]), 
					addMin = parseInt(add.split(':')[1]),
					toHour = parseInt(to.split(':')[0]),
					toMin = parseInt(to.split(':')[1]);
				toHour += addHour;
				toMin += addMin;
				if (toMin >= 60) {
					toMin -= 60;
					toHour += 1;
				}
				if (toHour >= 24) {
					toHour -= 24;
				}
				// Keep pretty double digit
				toHour = ('0' + toHour).slice(-2);
				toMin = ('0' + toMin).slice(-2);
				return `${toHour}:${toMin}`;
			}
		},
		mounted () {
			// console.log('Timetable mounted');
			this.populateList();
		}
	};
</script>

<style>
	.bar > input, select {
		display: inline-block;
		width: 8em;
		border: 1px solid #ddd;
		border-radius:  5px;
		padding: 0.2rem 1em;
		margin: 1em;
	}
	button {
		border: 2px solid #ddd;
		background-color: transparent;
		border-radius: 5px;
		padding: .5rem 2em;
		margin: 1em;
	}
</style>