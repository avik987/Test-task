# Test-task
as I understood our script should work from shall command, I created my main function under commands  folder CreateMiniatureController
Script should run via command line 
yii create-miniature 100,200x300 0, 1

where 100,200x300 is a param for sizes, 0 for waterMarked and 1 for catalogOnly
0 is for false 1 for true

under components folder created Images class and I implemented yiisoft/yii2-imagine package what creating thumbnails

database tables created via migration
