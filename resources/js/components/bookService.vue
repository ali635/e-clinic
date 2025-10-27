<template>
  <form class="bookService">
    <div class="slots_wrapper">
      <div v-for="(daySlots, day) in timeSlots" :key="day" class="slot_day">
        <p class="text-gray-800 font-medium mb-1 capitalize">{{ day }}</p>
  
        <div class="flex flex-wrap gap-3">
          <!-- 9:00 AM -->
          <label v-for="(slot, index) in daySlots.slots" :key="index" class="slot_time" :class="index%2 == 0 ? 'choosen_slot_time' : ''">
            <input :disabled="index%2 == 0" type="radio" class="option-input" name="timeSlots" :value="`${daySlots.date} ${slot.datetime}:00`" />
            <span class="text-sm text-gray-700">{{ slot.datetime }}</span>
          </label>
        </div>
      </div>
    </div>
  </form>
</template>

<script>
export default {
  name: 'bookService',
  data() {
    return {
      parsedObjData: {},
      bookedTimeSlots: [],
      service: {},
      timeSlots: {}
    }
  },
  props: ["dataObj"],
  methods: {
    generateTimeSlots(service) {
      const slots = {};
      const patientTimeMinute = service.patient_time_minute;
      
      service.schedules.forEach(schedule => {
          const scheduleSlots = [];
          
          // Parse start and end times
          const [startHour, startMinute] = schedule.start_time.split(':').map(Number);
          const [endHour, endMinute] = schedule.end_time.split(':').map(Number);
          
          // Convert to minutes for easier calculation
          let currentMinutes = startHour * 60 + startMinute;
          const endMinutes = endHour * 60 + endMinute;
          
          while (currentMinutes < endMinutes) {
              const slotStartHour = Math.floor(currentMinutes / 60);
              const slotStartMinute = currentMinutes % 60;
              
              const slotEndMinutes = currentMinutes + patientTimeMinute;
              const slotEndHour = Math.floor(slotEndMinutes / 60);
              const slotEndMinute = slotEndMinutes % 60;
              
              const formatTime = (hour, minute) => {
                  return `${String(hour).padStart(2, '0')}:${String(minute).padStart(2, '0')}`;
              };
              
              const slotStart = formatTime(slotStartHour, slotStartMinute);
              const slotEnd = formatTime(slotEndHour, slotEndMinute);
              
              scheduleSlots.push({
                  start: slotStart,
                  end: slotEnd,
                  display: `${slotStart} - ${slotEnd}`,
                  datetime: `${slotStart}`
              });
              
              currentMinutes += patientTimeMinute;
          }
          
          slots[schedule.day_of_week] = {
              day: schedule.day_of_week,
              date: schedule.date_of_day,
              schedule_id: schedule.id,
              slots: scheduleSlots
          };
      });
      
      return slots;
    },

  },
  mounted(){
    this.parsedObjData = this.dataObj ? JSON.parse(this.dataObj) : {};
    this.bookedTimeSlots = this.parsedObjData?.booked_times || [];
    this.service = this.parsedObjData?.service || {};
    this.timeSlots = this.generateTimeSlots(this.service);
    console.log("this.parsedObjData");
    console.log(this.parsedObjData);
    console.log("this.timeSlots");
    console.log(this.timeSlots);
    
  }
}
</script>

<style lang="scss" scoped>
.slots_wrapper {
  .slot_day {
    border: 1px solid #1f2937; 
    padding: 1rem; /* p-4 */
    border-radius: 0.5rem; /* rounded-lg */
    margin-bottom: 1rem; /* mb-4 */
  }
  .slot_time {
    position: relative;
    display: flex;
    align-items: center;
    gap: 0.5rem; /* gap-2 */
    border: 1px solid #e5e7eb; /* gray-200 */
    border-radius: 0.375rem; /* rounded-md */
    padding-left: 1rem;
    padding-right: 1rem;
    padding-top: 0.5rem;
    padding-bottom: 0.5rem; /* px-4 py-2 */
    min-height: 30px; /* min-h-[30px] */
    cursor: pointer;
    transition: all 0.2s;
    &:not(.choosen_slot_time):hover {
      background-color: #f3f4f6; /* hover:bg-gray-100 */
    }
    &.choosen_slot_time {
      opacity: 0.6;
      cursor: not-allowed;
    }
  }
}
</style>
