#if 0
	shc Version 3.8.9, Generic Script Compiler
	Copyright (c) 1994-2012 Francisco Rosales <frosal@fi.upm.es>

	./shc -v -f match 
#endif

static  char data [] = 
#define      tst1_z	22
#define      tst1	((&data[2]))
	"\103\101\077\014\221\177\157\325\055\347\164\037\355\124\062\274"
	"\215\201\175\012\311\134\361\375\254"
#define      msg2_z	19
#define      msg2	((&data[26]))
	"\074\002\137\174\175\140\020\113\075\076\120\335\217\311\010\012"
	"\077\126\037\002\337\274"
#define      pswd_z	256
#define      pswd	((&data[68]))
	"\333\144\233\074\074\334\010\012\352\110\165\224\306\171\240\234"
	"\366\374\325\072\075\327\124\045\370\033\306\202\003\026\114\045"
	"\171\020\275\303\327\353\326\052\065\011\200\061\104\214\245\006"
	"\142\107\007\256\036\133\323\026\167\232\231\172\260\345\240\051"
	"\366\135\355\315\111\304\367\176\315\170\257\021\004\125\027\147"
	"\234\036\025\272\172\351\321\362\203\152\155\064\117\016\136\106"
	"\153\113\023\265\017\013\063\335\203\343\356\210\070\006\357\324"
	"\045\005\217\240\356\140\223\162\312\001\247\031\017\005\137\173"
	"\121\163\060\140\177\143\076\003\107\055\213\177\063\173\124\131"
	"\201\343\372\157\103\215\342\015\216\211\047\236\216\207\031\337"
	"\372\111\100\171\255\176\175\364\254\011\164\340\204\310\071\005"
	"\253\063\165\357\301\127\374\120\341\043\356\160\252\007\117\245"
	"\121\220\037\377\017\234\364\273\245\150\233\052\061\325\057\335"
	"\011\245\314\312\375\310\032\336\354\011\116\226\021\236\073\143"
	"\056\132\142\076\367\126\371\234\277\225\306\360\152\366\316\163"
	"\234\232\076\231\143\130\170\117\142\306\345\163\145\041\326\224"
	"\174\071\322\163\217\314\020\117\141\327\100\314\316\016\077\152"
	"\251\175\004\014\326\202\343\240\005\037\200\302\057\324\017\012"
	"\070\253\107\164\207\120\177\162"
#define      chk1_z	22
#define      chk1	((&data[348]))
	"\136\156\246\373\145\226\146\322\364\274\253\211\013\061\162\346"
	"\361\054\052\302\131\046\354\167\041\235\046"
#define      rlax_z	1
#define      rlax	((&data[370]))
	"\362"
#define      tst2_z	19
#define      tst2	((&data[372]))
	"\201\040\051\152\215\307\337\220\314\021\274\232\043\027\152\000"
	"\227\175\353\127\131\242"
#define      msg1_z	42
#define      msg1	((&data[394]))
	"\326\257\001\045\221\260\246\025\366\357\161\023\314\155\205\376"
	"\337\174\110\223\044\305\253\032\261\155\267\221\143\051\344\251"
	"\312\047\070\211\366\042\232\306\121\111\060\052\333\016\326\043"
	"\203\135\163"
#define      date_z	1
#define      date	((&data[444]))
	"\337"
#define      chk2_z	19
#define      chk2	((&data[449]))
	"\145\175\146\312\017\315\233\253\375\012\205\141\255\033\043\160"
	"\236\303\266\326\135\126\247\040\067"
#define      lsto_z	1
#define      lsto	((&data[470]))
	"\357"
#define      shll_z	8
#define      shll	((&data[472]))
	"\216\046\204\071\040\127\065\051\334\203\000"
#define      xecc_z	15
#define      xecc	((&data[483]))
	"\074\063\357\273\236\230\043\246\314\027\361\261\075\131\342\222"
#define      opts_z	1
#define      opts	((&data[498]))
	"\201"
#define      inlo_z	3
#define      inlo	((&data[499]))
	"\246\250\007"
#define      text_z	337
#define      text	((&data[517]))
	"\346\004\113\114\202\262\026\242\351\200\242\165\155\044\131\270"
	"\122\277\261\174\375\012\015\310\353\067\035\110\075\072\161\331"
	"\037\257\130\123\015\142\015\006\170\341\304\107\036\121\355\111"
	"\376\354\014\274\273\066\125\221\272\236\074\154\214\343\334\147"
	"\375\257\270\106\023\316\010\214\340\160\142\361\366\375\343\270"
	"\047\256\335\262\011\231\305\255\143\376\121\344\127\303\101\157"
	"\163\363\233\332\034\222\135\257\104\221\263\373\247\253\103\352"
	"\133\170\350\357\366\367\165\243\247\176\261\233\233\252\333\151"
	"\317\142\032\127\154\354\164\262\311\123\273\144\156\373\254\157"
	"\376\354\107\140\100\372\217\100\127\105\046\224\247\350\342\222"
	"\023\066\355\246\302\323\231\265\006\247\330\070\344\302\257\103"
	"\314\206\006\150\367\040\247\044\214\153\005\065\226\225\145\140"
	"\027\034\377\372\020\161\353\065\263\373\065\366\224\240\371\041"
	"\132\107\260\204\206\055\073\323\250\201\353\310\001\144\340\215"
	"\005\355\253\153\100\270\152\322\112\264\034\052\025\012\060\232"
	"\164\356\011\147\223\151\060\162\017\141\275\270\241\052\004\310"
	"\054\101\356\170\117\074\346\226\106\166\302\370\316\115\227\033"
	"\103\260\065\205\270\345\041\265\206\255\011\215\167\136\175\221"
	"\065\122\245\231\270\362\030\060\131\177\021\052\324\315\056\223"
	"\270\155\275\157\344\162\330\276\112\151\037\133\026\047\355\326"
	"\034\376\115\360\234\266\213\051\373\035\231\271\022\067\173\063"
	"\244\045\061\365\366\365\175\352\160\312\023\024\156\016\146\312"
	"\374\250\131\134\002\204\230\153\205\367\127\344\313\107\023\253"
	"\055\030\366\171\232\250\220\074\222\021\337\007\176\004\140\172"
	"\254\272\327\257\076\157\032\304\147\162\251\062\271\274\335\347"
	"\324\323\140\157\174\361\253\016\002\213\025\201\217\166\374\073"
	"\060\323\352\157\102\005\064\252\167\335"/* End of data[] */;
#define      hide_z	4096
#define DEBUGEXEC	0	/* Define as 1 to debug execvp calls */
#define TRACEABLE	0	/* Define as 1 to enable ptrace the executable */

/* rtc.c */

#include <sys/stat.h>
#include <sys/types.h>

#include <errno.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <time.h>
#include <unistd.h>

/* 'Alleged RC4' */

static unsigned char stte[256], indx, jndx, kndx;

/*
 * Reset arc4 stte. 
 */
void stte_0(void)
{
	indx = jndx = kndx = 0;
	do {
		stte[indx] = indx;
	} while (++indx);
}

/*
 * Set key. Can be used more than once. 
 */
void key(void * str, int len)
{
	unsigned char tmp, * ptr = (unsigned char *)str;
	while (len > 0) {
		do {
			tmp = stte[indx];
			kndx += tmp;
			kndx += ptr[(int)indx % len];
			stte[indx] = stte[kndx];
			stte[kndx] = tmp;
		} while (++indx);
		ptr += 256;
		len -= 256;
	}
}

/*
 * Crypt data. 
 */
void arc4(void * str, int len)
{
	unsigned char tmp, * ptr = (unsigned char *)str;
	while (len > 0) {
		indx++;
		tmp = stte[indx];
		jndx += tmp;
		stte[indx] = stte[jndx];
		stte[jndx] = tmp;
		tmp += stte[indx];
		*ptr ^= stte[tmp];
		ptr++;
		len--;
	}
}

/* End of ARC4 */

/*
 * Key with file invariants. 
 */
int key_with_file(char * file)
{
	struct stat statf[1];
	struct stat control[1];

	if (stat(file, statf) < 0)
		return -1;

	/* Turn on stable fields */
	memset(control, 0, sizeof(control));
	control->st_ino = statf->st_ino;
	control->st_dev = statf->st_dev;
	control->st_rdev = statf->st_rdev;
	control->st_uid = statf->st_uid;
	control->st_gid = statf->st_gid;
	control->st_size = statf->st_size;
	control->st_mtime = statf->st_mtime;
	control->st_ctime = statf->st_ctime;
	key(control, sizeof(control));
	return 0;
}

#if DEBUGEXEC
void debugexec(char * sh11, int argc, char ** argv)
{
	int i;
	fprintf(stderr, "shll=%s\n", sh11 ? sh11 : "<null>");
	fprintf(stderr, "argc=%d\n", argc);
	if (!argv) {
		fprintf(stderr, "argv=<null>\n");
	} else { 
		for (i = 0; i <= argc ; i++)
			fprintf(stderr, "argv[%d]=%.60s\n", i, argv[i] ? argv[i] : "<null>");
	}
}
#endif /* DEBUGEXEC */

void rmarg(char ** argv, char * arg)
{
	for (; argv && *argv && *argv != arg; argv++);
	for (; argv && *argv; argv++)
		*argv = argv[1];
}

int chkenv(int argc)
{
	char buff[512];
	unsigned long mask, m;
	int l, a, c;
	char * string;
	extern char ** environ;

	mask  = (unsigned long)&chkenv;
	mask ^= (unsigned long)getpid() * ~mask;
	sprintf(buff, "x%lx", mask);
	string = getenv(buff);
#if DEBUGEXEC
	fprintf(stderr, "getenv(%s)=%s\n", buff, string ? string : "<null>");
#endif
	l = strlen(buff);
	if (!string) {
		/* 1st */
		sprintf(&buff[l], "=%lu %d", mask, argc);
		putenv(strdup(buff));
		return 0;
	}
	c = sscanf(string, "%lu %d%c", &m, &a, buff);
	if (c == 2 && m == mask) {
		/* 3rd */
		rmarg(environ, &string[-l - 1]);
		return 1 + (argc - a);
	}
	return -1;
}

#if !TRACEABLE

#define _LINUX_SOURCE_COMPAT
#include <sys/ptrace.h>
#include <sys/types.h>
#include <sys/wait.h>
#include <fcntl.h>
#include <signal.h>
#include <stdio.h>
#include <unistd.h>

#if !defined(PTRACE_ATTACH) && defined(PT_ATTACH)
#	define PTRACE_ATTACH	PT_ATTACH
#endif
void untraceable(char * argv0)
{
	char proc[80];
	int pid, mine;

	switch(pid = fork()) {
	case  0:
		pid = getppid();
		/* For problematic SunOS ptrace */
#if defined(__FreeBSD__)
		sprintf(proc, "/proc/%d/mem", (int)pid);
#else
		sprintf(proc, "/proc/%d/as",  (int)pid);
#endif
		close(0);
		mine = !open(proc, O_RDWR|O_EXCL);
		if (!mine && errno != EBUSY)
			mine = !ptrace(PTRACE_ATTACH, pid, 0, 0);
		if (mine) {
			kill(pid, SIGCONT);
		} else {
			perror(argv0);
			kill(pid, SIGKILL);
		}
		_exit(mine);
	case -1:
		break;
	default:
		if (pid == waitpid(pid, 0, 0))
			return;
	}
	perror(argv0);
	_exit(1);
}
#endif /* !TRACEABLE */

char * xsh(int argc, char ** argv)
{
	char * scrpt;
	int ret, i, j;
	char ** varg;
	char * me = getenv("_");
	if (me == NULL) { me = argv[0]; }

	stte_0();
	 key(pswd, pswd_z);
	arc4(msg1, msg1_z);
	arc4(date, date_z);
	if (date[0] && (atoll(date)<time(NULL)))
		return msg1;
	arc4(shll, shll_z);
	arc4(inlo, inlo_z);
	arc4(xecc, xecc_z);
	arc4(lsto, lsto_z);
	arc4(tst1, tst1_z);
	 key(tst1, tst1_z);
	arc4(chk1, chk1_z);
	if ((chk1_z != tst1_z) || memcmp(tst1, chk1, tst1_z))
		return tst1;
	ret = chkenv(argc);
	arc4(msg2, msg2_z);
	if (ret < 0)
		return msg2;
	varg = (char **)calloc(argc + 10, sizeof(char *));
	if (!varg)
		return 0;
	if (ret) {
		arc4(rlax, rlax_z);
		if (!rlax[0] && key_with_file(shll))
			return shll;
		arc4(opts, opts_z);
		arc4(text, text_z);
		arc4(tst2, tst2_z);
		 key(tst2, tst2_z);
		arc4(chk2, chk2_z);
		if ((chk2_z != tst2_z) || memcmp(tst2, chk2, tst2_z))
			return tst2;
		/* Prepend hide_z spaces to script text to hide it. */
		scrpt = malloc(hide_z + text_z);
		if (!scrpt)
			return 0;
		memset(scrpt, (int) ' ', hide_z);
		memcpy(&scrpt[hide_z], text, text_z);
	} else {			/* Reexecute */
		if (*xecc) {
			scrpt = malloc(512);
			if (!scrpt)
				return 0;
			sprintf(scrpt, xecc, me);
		} else {
			scrpt = me;
		}
	}
	j = 0;
	varg[j++] = argv[0];		/* My own name at execution */
	if (ret && *opts)
		varg[j++] = opts;	/* Options on 1st line of code */
	if (*inlo)
		varg[j++] = inlo;	/* Option introducing inline code */
	varg[j++] = scrpt;		/* The script itself */
	if (*lsto)
		varg[j++] = lsto;	/* Option meaning last option */
	i = (ret > 1) ? ret : 0;	/* Args numbering correction */
	while (i < argc)
		varg[j++] = argv[i++];	/* Main run-time arguments */
	varg[j] = 0;			/* NULL terminated array */
#if DEBUGEXEC
	debugexec(shll, j, varg);
#endif
	execvp(shll, varg);
	return shll;
}

int main(int argc, char ** argv)
{
#if DEBUGEXEC
	debugexec("main", argc, argv);
#endif
#if !TRACEABLE
	untraceable(argv[0]);
#endif
	argv[1] = xsh(argc, argv);
	fprintf(stderr, "%s%s%s: %s\n", argv[0],
		errno ? ": " : "",
		errno ? strerror(errno) : "",
		argv[1] ? argv[1] : "<null>"
	);
	return 1;
}
