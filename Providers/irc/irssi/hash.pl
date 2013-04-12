use strict;
use vars qw($VERSION %IRSSI);
use POSIX;

use Irssi qw(signal_add strip_codes);
$VERSION = '1.00';
%IRSSI = (
    authors     => '',
    contact     => '',
    name        => '',
    description => '',
    license     => 'Creative Commons Attribution 3.0 Unported License.',
);

sub msg_public {
my($server,$msg,$nick,$addr,$target)=@_;
my @msg1=split(' ',strip_codes($msg));
if ($target=='#gp.pre') {
  my $dt=POSIX::strftime("%F %T", localtime);
  open(FILE,'>>/var/www/newznab/misc/update_scripts/hash.txt'); #change this to a writeable file location that newznab can access
  print FILE $msg1[5]."\t".$dt."\n";
  close(FILE);
}

}
signal_add("message public","msg_public");