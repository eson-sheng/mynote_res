<template>
  <div>
    <div class="vux-demo">
      <img class="logo" src="../assets/vux_logo.png">
      <h1>Vux</h1>
    </div>
    <group title="Menu">
      <!--<cell title="no link"></cell>
      <cell title="Icon" value="Go"  is-link :link="{path: '/icons'}"></cell>
      <cell title="X-Icon" is-link :link="{path: '/xicons'}">Go</cell>
      <cell title="X-Button" is-link :link="{path: '/xbuttons'}"></cell>
      <cell title="FlexBox" is-link :link="{path: '/flexboxes'}"></cell>
      <cell title="Grid" is-link :link="{path: '/grids'}"></cell>
      <cell title="Sticky" is-link :link="{path: '/stickies'}"></cell>
      <cell title="Calendar" is-link :link="{path: '/Calendars'}"></cell>
      <cell title="CellBox" is-link :link="{path: '/cellboxes'}"></cell>
      <cell title="CellFormPreview" is-link :link="{path: '/cellformpreviews'}"></cell>
      <cell title="Cell" is-link :link="{path: '/cells'}"></cell>
      <cell title="CheckIcon" is-link :link="{path: '/checkicons'}"></cell>
      <cell title="Checkers" is-link :link="{path: '/checkers'}"></cell>
      <cell title="CheckList" is-link :link="{path: '/checklists'}"></cell>
      <cell title="DatetimeView" is-link :link="{path: '/datetimeviews'}"></cell>
      <cell title="DatetimeRange" is-link :link="{path: '/datetimeranges'}"></cell>
      <cell title="Datetimes" is-link :link="{path: '/datetimes'}"></cell>
      <cell title="Form-Preview" is-link :link="{path: '/formpreviews'}"></cell>
      <cell title="Group" is-link :link="{path: '/groups'}"></cell>
      <cell title="Switch" is-link :link="{path: '/switches'}"></cell>
      <cell title="Number" is-link :link="{path: '/numbers'}"></cell>
      <cell title="InlineCalendar" is-link :link="{path: '/inlinecalendars'}"></cell>
      <cell title="PopupPickers" is-link :link="{path: '/popuppickers'}"></cell>
      <cell title="PopupRadio" is-link :link="{path: '/popupradios'}"></cell>-->
      <cell title="Picker" is-link :link="{path: '/pickers'}"></cell>
      <cell title="Rater" is-link :link="{path: '/raters'}"></cell>
      <cell title="Range" is-link :link="{path: '/ranges'}"></cell>
      <cell title="Selector" is-link :link="{path: '/selectors'}"></cell>
      <cell title="Swipeout" is-link :link="{path: '/swipeouts'}"></cell>
    </group>
  </div>
</template>

<script>
import { Group, Cell} from 'vux'

export default {
  components: {Group, Cell}
}
</script>

<style>
  .vux-demo {
    text-align: center;
  }
  .logo {
    width: 100px;
    height: 100px
  }
</style>
