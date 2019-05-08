<style>
.tweetMenu {
  position: absolute;
  display: inline-block;
  left: 0px;
  top: 45px;
  border: 1px solid #ccc;
  font-size: 14px;
  padding: 15px;
  background: #fff;
  z-index: 1000;
  border-radius: 4px;
  box-shadow: 0px 3px 4px #ccc;
  color: #262626;
}

.tweetMenu > div {
  position: absolute;
  left: 12px;
  top: -8px;
	width: 0;
	height: 0;
	border-left: 8px solid transparent;
	border-right: 8px solid transparent;
	border-bottom: 8px solid #ccc;
}

.tweetMenu > div > div {
  position: relative;
  left: -8px;
  top: 1px;
	width: 0;
	height: 0;
	border-left: 8px solid transparent;
	border-right: 8px solid transparent;
	border-bottom: 8px solid #fff;
}

.tweetMenu li {
  white-space: nowrap;
  padding: 5px 0px;
}
</style>
