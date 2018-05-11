<div class="event-form form-screen pop-up">
  <button class="close-pop-up"><span class="icon-x"></span></button>
  <form name="event-form" method="post" enctype="multipart/form-data">
      <h1 class="form-title">Create Event</h1>
      <div class="form-content">
        <div class="box">
          <input type="file" id="file" name="file" class="inputfile" data-multiple-caption="{count} files selected" multiple />
          <label for="file">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
              <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z" />
            </svg>
            <span class="file-label">Choose a photo...</span>
            <button class="delete-files"><span class="icon-x-bold"></span></button>
          </label>
        </div>
        <input type="text" name="title" placeholder="Title*" required>
        <input type="text" name="start_date" class="date" placeholder="Start Date*" required>
        <input type="text" name="start_time" class="timepicker" placeholder="Start Time*" required>
        <h1 class="time-label">to</h1>
        <input type="text" name="end_date" class="date" placeholder="End Date">
        <input type="text" name="end_time" class="timepicker" placeholder="End Time">
        <input type="text" name="place" placeholder="Place">
        <input type="text" name="description" placeholder="Description">
        <p>* required form field</p>
      </div>
      <button type="submit" class="submit" name="submit" value="add-event">Add Event</button>
  </form>
</div>
